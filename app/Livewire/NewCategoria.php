<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CategoriaModel;

class NewCategoria extends Component
{
    use WithFileUploads;

    public $nombre = '';
    public $descripcion = '';
    public $foto; 
    public function render()
    {
        return view('livewire.new-categoria');
    }
    public function enviarClick()
    {
        $filename = time() . '_' . $this->foto->getClientOriginalName();

        $this->foto->storeAs('img', $filename, 'public');

        CategoriaModel::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'foto' => $filename,
        ]);
        return redirect()->route('categoria.listar');
    }
}
