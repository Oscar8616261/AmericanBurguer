<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmpresaModel;

class NewEmpresa extends Component
{
    public $nombre = '';
    public $direccion = '';
    public $latLog = '';
    public function render()
    {
        return view('livewire.new-empresa');
    }
    public function enviarClick()
    {
        EmpresaModel::create([
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'latLog' => $this->latLog,
        ]);
        return redirect()->route('empresa.listar');
    }
}
