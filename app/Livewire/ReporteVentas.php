<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductoModel;
use App\Models\TipoPagoModel;
use Illuminate\Support\Facades\DB;

class ReporteVentas extends Component
{
    public $month;
    public $year;

    public $summary = [];
    public $byDay = [];
    public $byPayment = [];
    public $topProducts = [];
    public $topProductMonth = null;

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

        $total = floatval($ventas->sum('total'));
        $count = intval($ventas->count());
        $avg = $count > 0 ? round($total / $count, 2) : 0;

        $ventaIds = $ventas->pluck('id_venta');
        $itemsVendidos = DetalleVentaModel::whereIn('id_venta', $ventaIds)->sum('cantidad');

        $this->summary = [
            'total' => $total,
            'count' => $count,
            'avg' => $avg,
            'items' => intval($itemsVendidos),
        ];

        $this->byDay = VentaModel::select(DB::raw('DATE(fecha_venta) as dia'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as cantidad'))
            ->where('status', 'confirmado')
            ->whereYear('fecha_venta', $this->year)
            ->whereMonth('fecha_venta', $this->month)
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->map(function ($row) {
                $dayIds = VentaModel::where('status', 'confirmado')
                    ->whereDate('fecha_venta', $row->dia)
                    ->pluck('id_venta');

                $topDay = DetalleVentaModel::select('id_producto', DB::raw('SUM(cantidad) as unidades'))
                    ->whereIn('id_venta', $dayIds)
                    ->groupBy('id_producto')
                    ->orderByDesc('unidades')
                    ->first();

                if ($topDay) {
                    $p = ProductoModel::find($topDay->id_producto);
                    $row->top_nombre = $p ? $p->nombre : 'Producto';
                    $row->top_unidades = intval($topDay->unidades);
                } else {
                    $row->top_nombre = '-';
                    $row->top_unidades = 0;
                }

                return $row;
            });

        $this->byPayment = VentaModel::select('id_pago', DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as cantidad'))
            ->where('status', 'confirmado')
            ->whereYear('fecha_venta', $this->year)
            ->whereMonth('fecha_venta', $this->month)
            ->groupBy('id_pago')
            ->get()
            ->map(function ($row) {
                $tipo = TipoPagoModel::find($row->id_pago);
                $row->nombre_pago = $tipo ? $tipo->nombre : 'Desconocido';
                return $row;
            });

        $this->topProducts = DetalleVentaModel::select('id_producto', DB::raw('SUM(cantidad) as unidades'), DB::raw('SUM(precio * cantidad) as total'))
            ->whereIn('id_venta', $ventaIds)
            ->groupBy('id_producto')
            ->orderByDesc('unidades')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                $p = ProductoModel::find($row->id_producto);
                $row->nombre = $p ? $p->nombre : 'Producto';
                $row->foto = $p ? $p->foto : null;
                return $row;
            });

        $first = collect($this->topProducts)->first();
        $this->topProductMonth = is_array($first) ? (object)$first : $first;
    }

    public function render()
    {
        return view('livewire.reporte-ventas');
    }
}