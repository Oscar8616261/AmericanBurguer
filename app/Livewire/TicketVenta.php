<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\ClienteModel;
use Illuminate\Support\Facades\DB;

class TicketVenta extends Component
{
    public $ventaId;
    public $venta;
    public $detalles = [];
    public $cliente;
    public $admin;

    public function mount($ventaId)
    {
        $this->ventaId = $ventaId;
        $this->venta = VentaModel::find($ventaId);
        $this->detalles = DetalleVentaModel::where('id_venta', $ventaId)->get();
        $this->cliente = $this->venta ? ClienteModel::find($this->venta->id_cliente) : null;
        $this->admin = $this->venta ? DB::table('Usuario')->where('id_usuario', $this->venta->id_usuario)->first() : null;
    }

    public function render()
    {
        return view('livewire.ticket-venta');
    }
}