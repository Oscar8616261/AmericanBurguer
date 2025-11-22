<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use App\Models\ClienteModel;
use App\Models\TipoPagoModel;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\DetalleOfertaModel;
use App\Models\EstrellasModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Ventascrud extends Component
{
    use LivewireAlert;

    // filtros y colecciones
    public $id_categoria = 1;
    public $productos = [];
    public $searchProducto = '';
    public $carrito = [];
    public $total = 0;
    public $searchCliente = '';
    public $clientes = [];
    public $recomendados = [];

    // datos cliente
    public $ciCliente;
    public $clienteId;
    public $nombre;
    public $apellidos;
    public $direccion;

    // pago
    public $tipoPago = ''; // nombre (opcional)
    public $tipoPagoId = null; // id_pago utilizado en DB
    public $efectivoId = null; // id pago correspondiente a "Efectivo" (si existe)
    public $montoRecibido = 0; // Monto recibido
    public $cambio = 0;
    public $tiposPago;

    // administradores (cuando cliente hace pedido)
    public $admins = [];
    public $selectedAdminId = null;

    // indicadores guard
    public $isAdmin = false;
    public $isCliente = false;

    // vistas: categoria | ofertas | destacados
    public $viewMode = 'categoria';
    public $limitDestacados = 6; // mostrar 6 destacados por defecto

    // Vista previa
    public $showPreview = false;
    public $previewVentaId = null;

    public function mount()
    {
        // Cargar tipos de pago filtrando nombres nulos
        $this->tiposPago = TipoPagoModel::whereNotNull('nombre')->get();

        // buscar id de "Efectivo" (insensible a mayúsculas)
        $this->efectivoId = TipoPagoModel::whereRaw("LOWER(nombre) LIKE ?", ['%efectivo%'])->value('id_pago');

        // si existe efectivo, seleccionarlo por defecto; si no, toma el primer tipo si hay
        if ($this->efectivoId) {
            $this->tipoPagoId = $this->efectivoId;
            $this->tipoPago = TipoPagoModel::where('id_pago', $this->efectivoId)->value('nombre') ?? 'Efectivo';
        } elseif ($this->tiposPago->count() > 0) {
            $first = $this->tiposPago->first();
            $this->tipoPagoId = $first->id_pago;
            $this->tipoPago = $first->nombre;
        } else {
            $this->tipoPagoId = null;
            $this->tipoPago = '';
        }

        // Guard check
        $this->isAdmin = Auth::guard('web')->check();
        $this->isCliente = Auth::guard('clientes')->check();

        // Cargar administradores desde la tabla Usuario (ajusta si es necesario)
        $this->admins = DB::table('Usuario')
            ->select('id_usuario', DB::raw("CONCAT(COALESCE(nombre,''),' ',COALESCE(apellidos,'')) as full_name"))
            ->orderBy('id_usuario')
            ->get()
            ->toArray();

        if ($this->isCliente) {
            $this->selectedAdminId = $this->admins && count($this->admins) ? ($this->admins[0]->id_usuario ?? 1) : 1;
        }
    }

    public function render()
    {
        // Cargar categorías
        $categorias = CategoriaModel::all();

        // Diferentes modos: categoria | ofertas | destacados
        if ($this->viewMode === 'ofertas') {
            // Detalles de oferta activas
            $detalles = DetalleOfertaModel::whereHas('oferta', function ($q) {
                    $q->whereDate('fecha_ini', '<=', now())
                      ->whereDate('fecha_fin', '>=', now());
                })->get();

            // Mapear a productos (usando ProductoModel::find para compatibilidad)
            $this->productos = $detalles->map(function ($detalle) {
                $producto = ProductoModel::find($detalle->id_producto);
                if (!$producto) return null;

                // promedio de estrellas
                $avg = EstrellasModel::where('id_producto', $producto->id_producto)->avg('puntuacion');
                $producto->promedio_estrellas = $avg ? round($avg) : 0;

                $producto->precio_mostrar = $detalle->precio_final;
                $producto->status = ProductoModel::STATUS_OFERTA ?? 'oferta';
                return $producto;
            })->filter()->values();
            $this->recomendados = [];

        } elseif ($this->viewMode === 'destacados') {
            // Obtener ids top por promedio de estrellas
            $topIds = EstrellasModel::select('id_producto', DB::raw('AVG(puntuacion) as avg_puntuacion'))
                ->groupBy('id_producto')
                ->orderByDesc('avg_puntuacion')
                ->limit($this->limitDestacados)
                ->pluck('id_producto')
                ->toArray();

            // traer productos y ordenar por ranking
            $productosQuery = ProductoModel::whereIn('id_producto', $topIds)
                ->where('status', '!=', ProductoModel::STATUS_BAJA ?? 'baja')
                ->get()
                ->keyBy('id_producto');

            $ordered = collect($topIds)->map(function ($id) use ($productosQuery) {
                return $productosQuery->get($id);
            })->filter()->values();

            // calcular precio_mostrar / status y promedio estrellas
            $this->productos = $ordered->map(function ($producto) {
                if (!$producto) return null;

                $detalle = DetalleOfertaModel::where('id_producto', $producto->id_producto)
                    ->whereHas('oferta', function ($q) {
                        $q->whereDate('fecha_ini', '<=', now())
                          ->whereDate('fecha_fin', '>=', now());
                    })->first();

                if ($detalle) {
                    $producto->precio_mostrar = $detalle->precio_final;
                    $producto->status = ProductoModel::STATUS_OFERTA ?? 'oferta';
                } else {
                    $producto->precio_mostrar = $producto->precio;
                    $producto->status = $producto->stock <= 0 ? (ProductoModel::STATUS_FUERA ?? 'fuera') : (ProductoModel::STATUS_DISPONIBLE ?? 'disponible');
                }

                // promedio de estrellas
                $avg = EstrellasModel::where('id_producto', $producto->id_producto)->avg('puntuacion');
                $producto->promedio_estrellas = $avg ? round($avg) : 0;

                return $producto;
            })->filter()->values();
            $this->recomendados = [];

        } else {
            // Modo por categoría (comportamiento original)
            $categoriaId = $this->id_categoria ?? 1;
            $query = ProductoModel::when($categoriaId, function ($q) use ($categoriaId) {
                    return $q->where('id_categoria', $categoriaId);
                })
                ->where('nombre', 'like', '%' . $this->searchProducto . '%')
                ->where('status', '!=', ProductoModel::STATUS_BAJA ?? 'baja')
                ->orderBy('nombre');

            $this->productos = $query->get()->map(function ($producto) {

                // promedio estrellas
                try {
                    $puntuaciones = EstrellasModel::where('id_producto', $producto->id_producto)->pluck('puntuacion');
                    $producto->promedio_estrellas = $puntuaciones->count() > 0 ? round($puntuaciones->avg()) : 0;
                } catch (\Throwable $e) {
                    $producto->promedio_estrellas = 0;
                }

                // buscar oferta activa para este producto
                $detalle = DetalleOfertaModel::where('id_producto', $producto->id_producto)
                    ->whereHas('oferta', function ($q) {
                        $q->whereDate('fecha_ini', '<=', now())
                            ->whereDate('fecha_fin', '>=', now());
                    })->first();

                if ($detalle) {
                    $producto->precio_mostrar = $detalle->precio_final;
                    $producto->status = ProductoModel::STATUS_OFERTA ?? 'oferta';
                } else {
                    $producto->precio_mostrar = $producto->precio;

                    if ($producto->status !== (ProductoModel::STATUS_BAJA ?? 'baja')) {
                        if ($producto->stock <= 0) {
                            $producto->status = ProductoModel::STATUS_FUERA ?? 'fuera';
                        } else {
                            $producto->status = ProductoModel::STATUS_DISPONIBLE ?? 'disponible';
                        }
                    }
                }

                return $producto;
            });

            $term = trim($this->searchProducto ?? '');
            $first = $term !== '' ? strtolower(explode(' ', $term)[0]) : '';
            $idsActuales = collect($this->productos)->pluck('id_producto')->all();
            $recomQuery = ProductoModel::where('id_categoria', $categoriaId)
                ->where('status', '!=', ProductoModel::STATUS_BAJA ?? 'baja');
            if ($first !== '') {
                $recomQuery = $recomQuery->whereRaw('LOWER(nombre) LIKE ?', ['%'.$first.'%']);
            }
            $recs = $recomQuery->orderBy('nombre')->limit(8)->get()->filter(function($p) use ($idsActuales){
                return !in_array($p->id_producto, $idsActuales);
            });
            $this->recomendados = $recs->map(function($producto){
                $detalle = DetalleOfertaModel::where('id_producto', $producto->id_producto)
                    ->whereHas('oferta', function ($q) {
                        $q->whereDate('fecha_ini', '<=', now())
                          ->whereDate('fecha_fin', '>=', now());
                    })->first();
                if ($detalle) {
                    $producto->precio_mostrar = $detalle->precio_final;
                    $producto->status = ProductoModel::STATUS_OFERTA ?? 'oferta';
                } else {
                    $producto->precio_mostrar = $producto->precio;
                    if ($producto->status !== (ProductoModel::STATUS_BAJA ?? 'baja')) {
                        if ($producto->stock <= 0) {
                            $producto->status = ProductoModel::STATUS_FUERA ?? 'fuera';
                        } else {
                            $producto->status = ProductoModel::STATUS_DISPONIBLE ?? 'disponible';
                        }
                    }
                }
                try {
                    $puntuaciones = EstrellasModel::where('id_producto', $producto->id_producto)->pluck('puntuacion');
                    $producto->promedio_estrellas = $puntuaciones->count() > 0 ? round($puntuaciones->avg()) : 0;
                } catch (\Throwable $e) {
                    $producto->promedio_estrellas = 0;
                }
                return $producto;
            });
        }

        return view('livewire.ventascrud', compact('categorias'));
    }

    /********** Métodos para cambio de vista **********/
    public function showCategoria()
    {
        $this->viewMode = 'categoria';
        $this->searchProducto = '';
        $this->id_categoria = $this->id_categoria ?? 1;
    }

    public function showOfertas()
    {
        $this->viewMode = 'ofertas';
        $this->searchProducto = '';
        $this->id_categoria = null;
    }

    public function showDestacados()
    {
        $this->viewMode = 'destacados';
        $this->searchProducto = '';
        $this->id_categoria = null;
    }

    /****************************************************/

    public function guardar()
    {
        // Validación básica: siempre requerimos que haya productos en el carrito
        $this->validate([
            'carrito' => 'required|array|min:1',
        ], [
            'carrito.required' => 'El carrito está vacío.',
            'carrito.min' => 'Agrega al menos un producto al carrito.',
        ]);

        // Calcular total actualizado
        $this->total = $this->calcularTotal();

        // Validaciones adicionales
        $rules = [];

        if ($this->isAdmin) {
            $rules['clienteId'] = 'required';
            $rules['tipoPagoId'] = 'required';
            // Si es efectivo, monto recibido debe ser >= 0 (puedes ajustar min si quieres)
            if ($this->tipoPagoId && $this->tipoPagoId == $this->efectivoId) {
                $rules['montoRecibido'] = ['required', 'numeric', 'min:0'];
            }
            $this->validate($rules);
        } elseif ($this->isCliente) {
            $rules['tipoPagoId'] = 'required';
            $this->validate($rules);
        } else {
            $this->alert('error', 'No hay usuario autenticado.');
            return;
        }

        $venta = new VentaModel();
        $venta->fecha_venta = now();
        $venta->total = $this->total;
        $venta->id_pago = $this->tipoPagoId ?? null;

        // ADMIN
        if ($this->isAdmin) {

            $venta->status = 'confirmado';
            $venta->id_usuario = Auth::guard('web')->id();
            $venta->id_cliente = $this->clienteId;

            $venta->save();

            // Guardar detalles y disminuir stock
            foreach ($this->carrito as $item) {
                $detalle = new DetalleVentaModel();
                $detalle->id_venta = $venta->id_venta;
                $detalle->id_producto = $item['id_producto'];
                $detalle->cantidad = $item['cantidad'];
                $detalle->precio = $item['precio'];
                $detalle->efectivo = $this->tipoPagoId == $this->efectivoId ? $this->montoRecibido : 0;
                $detalle->cambio = $this->tipoPagoId == $this->efectivoId ? $this->cambio : 0;
                $detalle->save();

                // Reducir stock y actualizar estado
                $producto = ProductoModel::find($item['id_producto']);

                if ($producto) {
                    $producto->stock = max(0, $producto->stock - $item['cantidad']);
                    $producto->save();

                    if (method_exists($producto, 'updateStatusByStockAndOffer')) {
                        $producto->updateStatusByStockAndOffer();
                    } else {
                        if ($producto->stock <= 0) {
                            $producto->status = ProductoModel::STATUS_FUERA ?? 'fuera';
                        } else {
                            $producto->status = ProductoModel::STATUS_DISPONIBLE ?? 'disponible';
                        }
                        $producto->save();
                    }
                }
            }

            // Reset props relevantes (AHORA INCLUYE ciCliente)
            $this->reset([
                'carrito',
                'total',
                'clienteId',
                'nombre',
                'apellidos',
                'direccion',
                'ciCliente',      // <--- limpiamos el CI aquí
                'montoRecibido',
                'cambio',
            ]);

            $this->dispatch('openTicket', $venta->id_venta);
        }
        // CLIENTE
        elseif ($this->isCliente) {

            $venta->status = 'pendiente';
            $venta->id_usuario = $this->selectedAdminId ?? 1;
            $venta->id_cliente = Auth::guard('clientes')->id();

            $venta->save();

            foreach ($this->carrito as $item) {
                $detalle = new DetalleVentaModel();
                $detalle->id_venta = $venta->id_venta;
                $detalle->id_producto = $item['id_producto'];
                $detalle->cantidad = $item['cantidad'];
                $detalle->precio = $item['precio'];
                $detalle->efectivo = $this->tipoPagoId == $this->efectivoId ? $this->montoRecibido : 0;
                $detalle->cambio = $this->tipoPagoId == $this->efectivoId ? $this->cambio : 0;
                $detalle->save();
            }

            // Reset props relevantes (INCLUYE ciCliente por si acaso)
            $this->reset([
                'carrito',
                'total',
                'montoRecibido',
                'cambio',
                'ciCliente',      // <--- limpiamos el CI también en el flujo cliente
            ]);

            $this->dispatch('openTicket', $venta->id_venta);
        }
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->previewVentaId = null;
    }

    // calcular cambio según monto recibido
    public function calculoCambio()
    {
        $this->total = $this->calcularTotal();
        // asegurar números
        $monto = floatval($this->montoRecibido ?? 0);
        if ($monto > $this->total) {
            $this->cambio = round($monto - $this->total, 2);
        } else {
            $this->cambio = 0;
        }
    }

    // cuando cambia el select (id del tipo de pago)
    public function updatedTipoPagoId($id)
    {
        // sincronizar nombre para uso eventual
        $this->tipoPago = TipoPagoModel::where('id_pago', $id)->value('nombre') ?? '';

        // si no es efectivo, limpiar monto y cambio
        if ($id == null || $id != $this->efectivoId) {
            $this->montoRecibido = 0;
            $this->cambio = 0;
        } else {
            // si es efectivo, recalcular cambio
            $this->calculoCambio();
        }
    }

    // cuando se actualiza el monto recibido por el usuario
    public function updatedMontoRecibido($value)
    {
        // forzar numeric
        $this->montoRecibido = is_numeric($value) ? floatval($value) : 0;
        $this->calculoCambio();
    }

    public function buscarCliente()
    {
        $cliente = ClienteModel::where('ci', $this->ciCliente)->first();

        if ($cliente) {
            $this->clienteId = $cliente->id_cliente;
            $this->nombre = $cliente->nombre;
            $this->apellidos = $cliente->apellidos;
            $this->direccion = $cliente->direccion;
        } else {
            $this->reset(['clienteId', 'nombre', 'apellidos', 'direccion']);
            $this->alert('error', 'Cliente no encontrado.');
        }
    }

    public function prodcutosCategoria($idCategoria)
    {
        $this->id_categoria = $idCategoria;
        $this->searchProducto = '';
        // con esto volvemos al modo por defecto de categoria
        $this->viewMode = 'categoria';
    }

    public function clickBuscar()
    {
        // Puedes implementar búsqueda avanzada si lo deseas.
        // Actualmente el render() utiliza $this->searchProducto en modo 'categoria'.
    }

    private function calcularTotal()
    {
        $total = 0;
        foreach ($this->carrito as $item) {
            $total += floatval($item['precio']) * intval($item['cantidad']);
        }
        return round($total, 2);
    }

    public function addProducto($idProducto)
    {
        $producto = ProductoModel::find($idProducto);
        if (!$producto) return;

        // comprobar stock disponible (server-side)
        if ($producto->stock <= 0) {
            $this->alert('warning', 'Producto sin stock. No se puede agregar al carrito.');
            return;
        }

        // buscar detalle de oferta activa para este producto
        $detalleOferta = DetalleOfertaModel::where('id_producto', $producto->id_producto)
            ->whereHas('oferta', function ($q) {
                $q->whereDate('fecha_ini', '<=', now())
                  ->whereDate('fecha_fin', '>=', now());
            })->first();

        // determinar precio para el carrito
        $precioParaCarrito = $detalleOferta ? $detalleOferta->precio_final : $producto->precio;

        // determinar estado legible
        if ($detalleOferta) {
            $statusProducto = ProductoModel::STATUS_OFERTA ?? 'oferta';
        } else {
            $statusProducto = $producto->stock <= 0 ? (ProductoModel::STATUS_FUERA ?? 'fuera') : (ProductoModel::STATUS_DISPONIBLE ?? 'disponible');
        }

        // Si ya existe en el carrito, incrementar cantidad (respetando stock)
        $exists = false;
        foreach ($this->carrito as &$item) {
            if ($item['id_producto'] == $idProducto) {
                if ($item['cantidad'] + 1 > $producto->stock) {
                    $this->alert('warning', 'Stock insuficiente para este producto.');
                    return;
                }
                $item['cantidad'] += 1;
                $exists = true;
                break;
            }
        }

        // Si no existe, agregar nuevo ítem con precio calculado y status
        if (!$exists) {
            // calcular promedio de estrellas para el item guardado en el carrito
            $avg = EstrellasModel::where('id_producto', $producto->id_producto)->avg('puntuacion');
            $promedio = $avg ? round($avg) : 0;

            $this->carrito[] = [
                'precio' => $precioParaCarrito,
                'cantidad' => 1,
                'id_producto' => $producto->id_producto,
                'producto' => array_merge($producto->toArray(), ['status' => $statusProducto, 'promedio_estrellas' => $promedio]),
            ];
        }

        // recalcular totales y cambio
        $this->total = $this->calcularTotal();
        $this->calculoCambio();
    }

    public function removeProducto($idProducto)
    {
        foreach ($this->carrito as $key => &$item) {
            if ($item['id_producto'] == $idProducto) {
                if ($item['cantidad'] > 1) {
                    $item['cantidad'] -= 1;
                } else {
                    unset($this->carrito[$key]);
                }
                break;
            }
        }

        // Reindex array
        $this->carrito = array_values($this->carrito);

        $this->total = $this->calcularTotal();
        $this->calculoCambio();
    }
}
