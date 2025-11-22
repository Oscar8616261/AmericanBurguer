<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductoModel;
use Illuminate\Support\Facades\DB;

class ReporteProductos extends Component
{
    public $month;
    public $year;

    public $summary = [];
    public $ranking = [];
    public $topProduct = null;

    public function mount()
    {
        $this->month = intval(now()->format('m'));
        $this->year = intval(now()->format('Y'));
        $this->loadData();
    }

    public function updatedMonth()
    {
        $this->loadData();
    }

    public function updatedYear()
    {
        $this->loadData();
    }

    protected function loadData()
    {
        $ventas = VentaModel::where('status', 'confirmado')
            ->whereYear('fecha_venta', $this->year)
            ->whereMonth('fecha_venta', $this->month)
            ->get();

        $ventaIds = $ventas->pluck('id_venta');

        $ranking = DetalleVentaModel::select('id_producto', DB::raw('SUM(cantidad) as unidades'), DB::raw('SUM(precio * cantidad) as total'))
            ->whereIn('id_venta', $ventaIds)
            ->groupBy('id_producto')
            ->orderByDesc('unidades')
            ->limit(20)
            ->get()
            ->map(function ($row) {
                $p = ProductoModel::find($row->id_producto);
                $row->nombre = $p ? $p->nombre : 'Producto';
                $row->foto = $p ? $p->foto : null;
                $row->precio_unidad = $p ? $p->precio : null;
                return $row;
            });

        $this->ranking = $ranking;

        $this->topProduct = collect($ranking)->first();
        if (is_array($this->topProduct)) {
            $this->topProduct = (object)$this->topProduct;
        }

        $this->summary = [
            'productos_vendidos' => intval($ranking->count()),
            'unidades_total' => intval($ranking->sum('unidades')),
            'ingresos_total' => floatval($ranking->sum('total')),
        ];
    }

    public function render()
    {
        return view('livewire.reporte-productos');
    }
}