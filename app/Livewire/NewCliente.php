<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClienteModel;

class NewCliente extends Component
{
    public $nombre = '';
    public $apellidos = '';
    public $ci = '';
    public $nit = '';
    public $email = '';
    public function render()
    {
        return view('livewire.new-cliente');
    }
    public function enviarClick()
    {
        ClienteModel::create([
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'ci' => $this->ci,
            'nit' => $this->nit,
            'email' => $this->email,
        ]);
        return redirect()->route('cliente.listar');
    }
}
