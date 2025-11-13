<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use App\Models\ClienteModel;
use App\Models\TipoPagoModel;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Ventascrud extends Component
{
    use LivewireAlert;

    public $id_categoria = 1;
    public $productos = [];
    public $searchProducto = '';
    public $carrito = [];
    public $total = 0;
    public $searchCliente = '';
    public $clientes = [];

    public $ciCliente;
    public $clienteId;
    public $nombre;
    public $apellidos;
    public $nit;

    public $tipoPago = "Efectivo";
    public $tipoPagoId;
    public $montoRecibido = 0; // Monto recibido
    public $cambio = 0;
    public $tiposPago;

    // NUEVO: lista de administradores y admin seleccionado (cuando cliente está logueado)
    public $admins = [];
    public $selectedAdminId = null;

    // INDICADORES del guard (útil en la vista y lógica)
    public $isAdmin = false;
    public $isCliente = false;

    public function mount()
    {
        $this->tiposPago = TipoPagoModel::all();
        $this->tipoPagoId = TipoPagoModel::where('nombre', 'Efectivo')->value('id_pago');

        // Determinar guard activo
        $this->isAdmin = Auth::guard('web')->check();
        $this->isCliente = Auth::guard('clientes')->check();

        // Cargar administradores desde la tabla Usuario (ajusta columnas si tu tabla difiere)
        // Usamos DB para no depender de un model Usuario existente.
        $this->admins = DB::table('Usuario')
            ->select('id_usuario', DB::raw("CONCAT(COALESCE(nombre,''),' ',COALESCE(apellidos,'')) as full_name"))
            ->orderBy('id_usuario')
            ->get()
            ->toArray();

        // Si el usuario es cliente autenticado, por defecto podemos preseleccionar admin 1 (opcional)
        if ($this->isCliente) {
            $this->selectedAdminId = $this->admins && count($this->admins) ? ($this->admins[0]->id_usuario ?? 1) : 1;
        }
    }

    public function render()
    {
        $categorias = CategoriaModel::all();
        $this->productos = ProductoModel::where('id_categoria', $this->id_categoria)
            ->where('nombre', 'like', '%' . $this->searchProducto . '%')
            ->get();

        return view('livewire.ventascrud', compact('categorias'));
    }

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

        $venta = new VentaModel();
        $venta->fecha_venta = now();
        $venta->total = $this->total;

        // Diferenciar según el guard autenticado
        if (Auth::guard('web')->check()) {
            // Administrador -> venta confirmada y descuenta stock
            $this->validate([
                'clienteId' => 'required',
                'montoRecibido' => 'required',
            ], [
                'clienteId.required' => 'Selecciona un cliente para la venta.',
                'montoRecibido.required' => 'Ingrese el monto recibido.',
            ]);

            $venta->status = 'confirmado';
            $venta->id_usuario = Auth::guard('web')->id();
            $venta->id_cliente = $this->clienteId;
            $venta->id_pago = $this->tipoPagoId ?? null;

            $venta->save();

            // Guardar detalles y disminuir stock
            foreach ($this->carrito as $item) {
                $detalle = new DetalleVentaModel();
                $detalle->id_venta = $venta->id_venta;
                $detalle->id_producto = $item['id_producto'];
                $detalle->cantidad = $item['cantidad'];
                $detalle->precio = $item['precio'];
                $detalle->efectivo = $this->montoRecibido;
                $detalle->cambio = $this->cambio;
                $detalle->save();

                // Reducir stock (solo en ventas confirmadas)
                $producto = ProductoModel::find($item['id_producto']);
                if ($producto) {
                    $producto->stock = max(0, $producto->stock - $item['cantidad']);
                    $producto->save();
                }
            }

            // Limpiar campos relevantes
            $this->reset([
                'carrito',
                'total',
                'clienteId',
                'nombre',
                'apellidos',
                'nit',
                'ciCliente',
                'montoRecibido',
                'cambio',
            ]);

            $this->alert('success', 'Venta confirmada y guardada con éxito.');

        } elseif (Auth::guard('clientes')->check()) {
            // Cliente autenticado -> crear pedido en estado 'pendiente', no descontar stock
            $venta->status = 'pendiente';

            // Asignar admin elegido por el cliente o fallback a 1
            $venta->id_usuario = $this->selectedAdminId ?? 1;

            $venta->id_cliente = Auth::guard('clientes')->id();
            $venta->id_pago = $this->tipoPagoId ?? null;

            $venta->save();

            // Guardar detalles sin tocar stock
            foreach ($this->carrito as $item) {
                $detalle = new DetalleVentaModel();
                $detalle->id_venta = $venta->id_venta;
                $detalle->id_producto = $item['id_producto'];
                $detalle->cantidad = $item['cantidad'];
                $detalle->precio = $item['precio'];
                $detalle->efectivo = $this->montoRecibido;
                $detalle->cambio = $this->cambio;
                $detalle->save();
            }

            // Reset del carrito y montos; no reseteo datos de sesión del cliente
            $this->reset([
                'carrito',
                'total',
                'montoRecibido',
                'cambio',
            ]);

            $this->alert('success', 'Pedido creado y guardado como PENDIENTE.');
        } else {
            // Ningún guard válido: rechazo
            $this->alert('error', 'No hay usuario autenticado (ni admin ni cliente).');
            return;
        }
    }

    // Resto de métodos (calculoCambio, updatedTipoPago, buscarCliente, etc.) quedan igual
    public function calculoCambio()
    {
        $this->total = $this->calcularTotal();
        if ($this->montoRecibido > $this->total) {
            $this->cambio = $this->montoRecibido - $this->total;
        } else {
            $this->cambio = 0;
        }
    }

    public function updatedTipoPago($nombre)
    {
        $this->tipoPagoId = TipoPagoModel::where('nombre', $nombre)->value('id_pago');

        if ($this->tipoPago != "Efectivo") {
            $this->montoRecibido = 0;
            $this->cambio = 0;
        }
    }

    public function buscarCliente()
    {
        $cliente = ClienteModel::where('ci', $this->ciCliente)->first();

        if ($cliente) {
            $this->clienteId = $cliente->id_cliente;
            $this->nombre = $cliente->nombre;
            $this->apellidos = $cliente->apellidos;
            $this->nit = $cliente->nit;
        } else {
            $this->reset(['clienteId', 'nombre', 'apellidos', 'nit']);
            $this->alert('error', 'Cliente no encontrado.');
        }
    }

    public function prodcutosCategoria($idCategoria)
    {
        $this->id_categoria = $idCategoria;
        $this->searchProducto = '';
    }

    public function clickBuscar()
    {
        // Buscar productos si se presiona Enter o botón
    }

    private function calcularTotal()
    {
        $total = 0;
        foreach ($this->carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }

    public function addProducto($idProducto)
    {
        $producto = ProductoModel::find($idProducto);
        if (!$producto) return;

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

        if (!$exists) {
            $this->carrito[] = [
                'precio' => $producto->precio,
                'cantidad' => 1,
                'id_producto' => $producto->id_producto,
                'producto' => $producto->toArray()
            ];
        }

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
