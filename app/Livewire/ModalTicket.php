<?php

namespace App\Livewire;

use Livewire\Component;

class ModalTicket extends Component
{
    public $show = false;
    public $ventaId = null;

    protected $listeners = [
        'openTicket' => 'open',
        'closeTicket' => 'close',
    ];

    public function open($ventaId)
    {
        $this->ventaId = $ventaId;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
        $this->ventaId = null;
    }

    public function render()
    {
        return view('livewire.modal-ticket');
    }
}