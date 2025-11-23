<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use App\Models\EstrellasModel;
use App\Models\DetalleVentaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\DetalleOfertaModel;
use App\Models\OfertaModel;

class ListaProductos extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;

    public $search = '';
    public $showModal = false;
    public $showModal2 = false;

    public $nombre = '';
    public $descripcion = '';
    public $precio = '';
    public $stock = '';
    public $categoria = '';
    public $foto;
    public $producto_id = '';
    public $puntuacion = 0;

    // estado editable en editar
    public $status = '';

    // Aumentar stock modal
    public $showIncreaseModal = false;
    public $increaseProductId = null;
    public $increaseAmount = 1;

    protected $paginationTheme = 'tailwind';

    // Oferta
    public $showOfertaModal = false;
    public $ofertaProductoId = null;   // id del producto para el que abrimos modal
    public $ofertaId = null;          // id de la oferta seleccionada
    public $ofertas = [];             // colección de ofertas disponibles
    public $precio_final = null;      // calculado en el front

    protected function rules()
    {
        $rules = [
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'required',
            'categoria' => 'required',
        ];

        if (!$this->producto_id || ($this->foto && is_object($this->foto))) {
            $rules['foto'] = ['image', 'max:10024'];
        }

        return $rules;
    }

    public function clickBuscar()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->limpiarDatos();
    }

    public function openModal2()
    {
        $this->showModal2 = true;
    }

    public function closeModal2()
    {
        $this->showModal2 = false;
        $this->limpiarDatos();
    }

    public function calificar($id)
    {
        $this->openModal2();
        $this->producto_id = $id;
    }

    public function seleccionarEstrella($valor)
    {
        $this->puntuacion = $valor;
    }

    public function guardarCalificacion()
    {
        $this->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        EstrellasModel::create([
            'id_producto' => $this->producto_id,
            'id_cliente' => Auth::guard('clientes')->id(),
            'puntuacion' => $this->puntuacion,
        ]);

        $this->closeModal2();
        $this->alert('success', 'Calificación Guardada!');
    }

    /**
     * Abrir modal Oferta para $id (producto).
     */
    public function openOfertaModal($id)
    {
        $this->ofertaProductoId = $id;

        // Cargar ofertas activas (filtrar por fecha)
        $this->ofertas = OfertaModel::whereDate('fecha_ini', '<=', now())
                                    ->whereDate('fecha_fin', '>=', now())
                                    ->orderBy('fecha_ini', 'desc')
                                    ->get();

        $this->ofertaId = null;
        $this->precio_final = null;
        $this->showOfertaModal = true;
    }

    /**
     * Calcula precio_final según oferta seleccionada y precio actual del producto.
     */
    public function calcularPrecio()
    {
        $producto = ProductoModel::find($this->ofertaProductoId);
        if (!$producto) {
            $this->precio_final = null;
            return;
        }

        if (!$this->ofertaId) {
            $this->precio_final = null;
            return;
        }

        $oferta = OfertaModel::find($this->ofertaId);
        if (!$oferta) {
            $this->precio_final = null;
            return;
        }

        // Asumimos 'descuento' es porcentaje (ej. 15 -> 15%)
        $descuento = floatval($oferta->descuento);
        $precio = floatval($producto->precio);

        $this->precio_final = round($precio * (1 - ($descuento / 100)), 2);
    }

    /**
     * Guarda/actualiza el Detalle_oferta para el producto seleccionado.
     */
    public function guardarDetalleOferta()
    {
        $this->validate(['ofertaId' => 'required|integer']);

        $producto = ProductoModel::find($this->ofertaProductoId);
        $oferta   = OfertaModel::find($this->ofertaId);

        if (!$producto || !$oferta) {
            $this->alert('error', 'Producto u Oferta no encontrados.');
            return;
        }

        $descuento    = floatval($oferta->descuento);
        $precio_final = round(floatval($producto->precio) * (1 - ($descuento / 100)), 2);

        // Crea o actualiza detalle de oferta
        DetalleOfertaModel::updateOrCreate(
            ['id_producto' => $producto->id_producto],
            [
                'id_oferta'    => $oferta->id_oferta,
                'precio_final' => $precio_final,
            ]
        );

        $producto->status = ProductoModel::STATUS_OFERTA;
        $producto->save();

        $this->alert('success', "Oferta aplicada. Precio final: Bs {$precio_final}");
        $this->showOfertaModal = false;
    }

    public function render()
    {
        $query = ProductoModel::where('status', '!=', ProductoModel::STATUS_BAJA)
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('nombre');

        $productos = $query->paginate(6);

        $productos->getCollection()->transform(function ($producto) {
            // 1) Promedio estrellas
            $puntuaciones = EstrellasModel::where('id_producto', $producto->id_producto)->pluck('puntuacion');
            $producto->promedio_estrellas = $puntuaciones->count() > 0 ? round($puntuaciones->avg()) : 0;

            // Precio original SIEMPRE
            $producto->precio_original = $producto->precio;

            // 2) Buscar detalle de oferta activo para este producto
            $detalle = DetalleOfertaModel::where('id_producto', $producto->id_producto)
                ->whereHas('oferta', function ($q) {
                    $q->whereDate('fecha_ini', '<=', now())
                      ->whereDate('fecha_fin', '>=', now());
                })->first();

            if ($detalle) {
                // Con oferta activa
                $producto->precio_oferta  = $detalle->precio_final;
                $producto->en_oferta      = true;
                $producto->precio_mostrar = $detalle->precio_final;
                $producto->status         = ProductoModel::STATUS_OFERTA;
            } else {
                // Sin oferta activa
                $producto->precio_oferta  = null;
                $producto->en_oferta      = false;
                $producto->precio_mostrar = $producto->precio;

                if ($producto->status !== ProductoModel::STATUS_BAJA) {
                    if ($producto->stock <= 0) {
                        $producto->status = ProductoModel::STATUS_FUERA;
                    } else {
                        $producto->status = ProductoModel::STATUS_DISPONIBLE;
                    }
                }
            }

            return $producto;
        });

        $categorias = CategoriaModel::all();

        return view('livewire.lista-productos', [
            'productos'  => $productos,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Guardar (crear o actualizar) producto.
     */
    public function enviarClick()
    {
        $this->validate();

        $stockInt     = intval($this->stock);
        $categoriaInt = intval($this->categoria);

        if ($this->producto_id) {
            $producto = ProductoModel::find($this->producto_id);
            if (!$producto) {
                $this->alert('error', 'Producto no encontrado.');
                return;
            }

            $producto->nombre       = $this->nombre;
            $producto->precio       = $this->precio;
            $producto->stock        = $stockInt;
            $producto->descripcion  = $this->descripcion;
            $producto->id_categoria = $categoriaInt;

            if ($this->foto && is_object($this->foto)) {
                $filename = time() . '_' . $this->foto->getClientOriginalName();
                $this->foto->storeAs('img', $filename, 'public');
                $producto->foto = $filename;
            }

            // Si el admin cambió manualmente status
            if ($this->status) {
                $producto->status = $this->status;
            }

            $producto->save();

            // Forzar consistencia de estado (si no es 'baja')
            if (method_exists($producto, 'updateStatusByStockAndOffer')) {
                $producto->updateStatusByStockAndOffer();
            }

            $this->producto_id = '';
        } else {
            $filename = time() . '_' . $this->foto->getClientOriginalName();
            $this->foto->storeAs('img', $filename, 'public');

            $producto = ProductoModel::create([
                'nombre'       => $this->nombre,
                'descripcion'  => $this->descripcion,
                'precio'       => $this->precio,
                'stock'        => $stockInt,
                'id_categoria' => $categoriaInt,
                'foto'         => $filename,
                'status'       => ProductoModel::STATUS_DISPONIBLE,
            ]);

            if (method_exists($producto, 'updateStatusByStockAndOffer')) {
                $producto->updateStatusByStockAndOffer();
            }
        }

        $this->alert('success', 'Datos Guardados!');
        $this->limpiarDatos();
        $this->closeModal();
        $this->resetPage();
    }

    public function editar($id)
    {
        $producto = ProductoModel::find($id);
        if (!$producto) {
            $this->alert('error', 'Producto no encontrado!');
            return;
        }

        $this->nombre      = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->precio      = $producto->precio;
        $this->stock       = $producto->stock;
        $this->categoria   = $producto->id_categoria;
        $this->status      = $producto->status;
        $this->foto        = $producto->foto;
        $this->producto_id = $id;
        $this->openModal();
    }

    /**
     * Abre modal para aumentar stock (admin).
     */
    public function openIncreaseModal($id)
    {
        $this->increaseProductId = $id;
        $this->increaseAmount    = 1;
        $this->showIncreaseModal = true;
    }

    /**
     * Confirma el aumento de stock desde el modal.
     */
    public function increaseStockConfirm()
    {
        $this->validate([
            'increaseAmount' => 'required|integer|min:1',
        ]);

        $id     = $this->increaseProductId;
        $amount = intval($this->increaseAmount);

        $producto = ProductoModel::find($id);
        if (!$producto) {
            $this->alert('error', 'Producto no encontrado.');
            $this->showIncreaseModal = false;
            return;
        }

        $oldStock       = intval($producto->stock);
        $producto->stock = $oldStock + $amount;

        if ($producto->status !== ProductoModel::STATUS_BAJA) {
            if ($oldStock <= 0 && $producto->stock > 0) {
                if (DB::table('Detalle_oferta')->where('id_producto', $producto->id_producto)->exists()) {
                    $producto->status = ProductoModel::STATUS_OFERTA;
                } else {
                    $producto->status = ProductoModel::STATUS_DISPONIBLE;
                }
            } else {
                if (method_exists($producto, 'updateStatusByStockAndOffer')) {
                    $producto->updateStatusByStockAndOffer();
                }
            }
        }

        $producto->save();

        $this->alert('success', "Stock aumentado. Nuevo stock: {$producto->stock}");
        $this->showIncreaseModal = false;
        $this->increaseProductId = null;
        $this->increaseAmount    = 1;
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $s = EstrellasModel::where('id_producto', $id)->get();
            $v = DetalleVentaModel::where('id_producto', $id)->get();
            if (count($s) == 0 && count($v) == 0) {
                $producto = ProductoModel::find($id);
                $producto->delete();
                $this->alert('success', 'Producto Eliminado!');
                $this->limpiarDatos();
                $this->resetPage();
            } else {
                $this->alert('warning', 'No se puede borrar el producto; tiene relaciones.');
            }
        } catch (Exception $e) {
            $this->alert('error', 'No se puede eliminar el producto');
        }
    }

    public function limpiarDatos()
    {
        $this->nombre            = '';
        $this->descripcion       = '';
        $this->precio            = '';
        $this->stock             = '';
        $this->categoria         = '';
        $this->foto              = null;
        $this->producto_id       = '';
        $this->puntuacion        = null;
        $this->status            = '';
        $this->showIncreaseModal = false;
        $this->increaseProductId = null;
        $this->increaseAmount    = 1;
    }
}
