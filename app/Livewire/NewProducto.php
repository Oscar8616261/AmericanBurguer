<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;

class NewProducto extends Component
{
    use WithFileUploads;

    public $nombre = '';
    public $descripcion = '';
    public $precio = '';
    public $stock = '';
    public $categoria = '';
    public $foto; 

    public function render()
    {
        $categorias = CategoriaModel::all();
        return view('livewire.new-producto', compact('categorias'));
    }

    public function enviarClick()
    {
        $filename = time() . '_' . $this->foto->getClientOriginalName();

        $this->foto->storeAs('img', $filename, 'public');

        ProductoModel::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => intval($this->stock),
            'id_categoria' => intval($this->categoria),
            'foto' => $filename,
        ]);
        return redirect()->route('home');
    }
}
