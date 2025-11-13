<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class VentasPendientes extends Component
{
    use LivewireAlert;

    public $ventas = [];

    public function mount()
    {
        $this->loadVentasPendientes();
    }

    public function render()
    {
        return view('livewire.ventas-pendientes');
    }

    protected function loadVentasPendientes()
    {
        // Traemos las ventas pendientes con sus detalles y productos
        $this->ventas = VentaModel::where('status', 'pendiente')
            ->with(['detalles.producto', 'cliente'])
            ->orderBy('fecha_venta', 'desc')
            ->get();
    }

    public function confirmVenta($idVenta)
    {
        // Solo administradores (guard web) pueden confirmar
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

            // Primero verificar stock suficiente para todos los productos
            foreach ($venta->detalles as $detalle) {
                $producto = ProductoModel::find($detalle->id_producto);
                if (!$producto) {
                    throw new \Exception("Producto (ID {$detalle->id_producto}) no encontrado.");
                }
                if ($producto->stock < $detalle->cantidad) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre} (ID {$producto->id_producto}). Stock actual: {$producto->stock}, requerido: {$detalle->cantidad}.");
                }
            }

            // Actualizar venta
            $venta->status = 'confirmado';
            $venta->id_usuario = Auth::guard('web')->id();
            $venta->save();

            // Descontar stock para cada detalle
            foreach ($venta->detalles as $detalle) {
                $producto = ProductoModel::find($detalle->id_producto);
                $producto->stock = max(0, $producto->stock - $detalle->cantidad);
                $producto->save();
            }

            DB::commit();

            $this->alert('success', 'Venta confirmada y stock actualizado correctamente.');
            $this->loadVentasPendientes(); // refrescar lista

        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Error al confirmar la venta: ' . $e->getMessage());
            // opcional: loguear el error
            // \Log::error('Error confirmando venta pendiente', ['id' => $idVenta, 'error' => $e->getMessage()]);
        }
    }
}
