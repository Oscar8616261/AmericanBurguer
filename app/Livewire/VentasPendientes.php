<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VentaModel;
use App\Models\ProductoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class VentasPendientes extends Component
{
    use LivewireAlert;

    public $ventas; // colección de ventas (pendientes)
    public $pendientesCount = 0;
    public $showPreview = false;
    public $previewVentaId = null;

    protected $listeners = [
        // permite refrescar desde JS u otros componentes: Livewire.emit('refreshVentasList')
        'refreshVentasList' => 'loadVentasPendientes'
    ];

    public function mount()
    {
        $this->loadVentasPendientes();
    }

    public function render()
    {
        return view('livewire.ventas-pendientes');
    }

    // carga la lista y el contador
    public function loadVentasPendientes()
    {
        $this->ventas = VentaModel::where('status', 'pendiente')
            ->with(['detalles.producto', 'cliente'])
            ->orderBy('fecha_venta', 'desc')
            ->get();

        // contador ligero
        $this->pendientesCount = $this->ventas->count();
    }

    // confirmar venta: solo administradores (guard 'web')
    public function confirmVenta($idVenta)
    {
        if (!Auth::guard('web')->check()) {
            $this->alert('error', 'Sólo un administrador puede confirmar ventas.');
            return;
        }

        try {
            DB::beginTransaction();

            $venta = VentaModel::with('detalles')->findOrFail($idVenta);

            if ($venta->status !== 'pendiente') {
                throw new \Exception('La venta no está en estado pendiente.');
            }

            // verificar stock suficiente
            foreach ($venta->detalles as $detalle) {
                $producto = ProductoModel::find($detalle->id_producto);
                if (!$producto) {
                    throw new \Exception("Producto (ID {$detalle->id_producto}) no encontrado.");
                }
                if ($producto->stock < $detalle->cantidad) {
                    throw new \Exception("Stock insuficiente para: {$producto->nombre}. Disponible: {$producto->stock}, requerido: {$detalle->cantidad}.");
                }
            }

            // actualizar venta
            $venta->status = 'confirmado';
            $venta->id_usuario = Auth::guard('web')->id();
            $venta->save();

            // descontar stock
            foreach ($venta->detalles as $detalle) {
                $producto = ProductoModel::find($detalle->id_producto);
                $producto->stock = max(0, $producto->stock - $detalle->cantidad);
                $producto->save();
            }

            DB::commit();

            $this->loadVentasPendientes();
            $this->dispatch('openTicket', $venta->id_venta);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Error al confirmar la venta: ' . $e->getMessage());
            // opcional: \Log::error('Error confirmando venta', ['id' => $idVenta, 'error' => $e->getMessage()]);
        }
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->previewVentaId = null;
    }
}
