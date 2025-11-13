<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use Alert;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class ListaCategoria extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;

    public $search='';
    public $showModal=false;

    public $nombre = '';
    public $descripcion = '';
    public $foto; 
    public $categoria_id='';
   
    protected function rules(){
        $rules = [
            'nombre' => 'required',
            'descripcion' => 'required',
        ];
        
        if (($this->categoria_id && is_object($this->foto)) ){
            $rules['foto']=['image','max:10024'];
        }
        else if($this->categoria_id=='')
            $rules['foto']=['image','max:10024'];
        return $rules;
    }

    public function clickBuscar(){

    }
    public function openModal(){
        $this->showModal=true;
    }
    public function closeModal(){
        $this->showModal=false;
        $this->limpiarDatos();
    }

    public function render()
    {
        $categorias = CategoriaModel::where('nombre','like','%'.$this->search.'%')->paginate(6);
        return view('livewire.lista-categoria',compact('categorias'));
    }

    public function enviarClick()
    {
        $this->validate();
        if($this->categoria_id){
            $categoria = CategoriaModel::find($this->categoria_id);
            $categoria->nombre = $this->nombre;
            $categoria->descripcion = $this->descripcion;
            if ($this->foto && is_object($this->foto)) {
                $filename = time() . '_' . $this->foto->getClientOriginalName();
                $this->foto->storeAs('img', $filename, 'public');
                $categoria->foto = $filename;
            }
            $categoria->save();
            $this->categoria_id = '';
        }else{
        
        $filename = time() . '_' . $this->foto->getClientOriginalName();

        $this->foto->storeAs('img', $filename, 'public');

        CategoriaModel::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'foto' => $filename,
        ]);
        }
        $this->alert('success', 'Datos Guardados!');
        $this->limpiarDatos();
       $this->closeModal();
    }

    
    public function editar($id){
        
        $categoria = CategoriaModel::find($id);
        $this->nombre = $categoria->nombre;
        $this->descripcion = $categoria->descripcion;
        if (!$this->foto) {
            $this->foto = $categoria->foto;
        }
        
        $this->categoria_id = $id;
        $this->openModal();
    }
    

    public function delete($id){
        try{
            $usados = ProductoModel::where('id_categoria',$id)->get();
            if(count($usados)==0){
                $categoria = CategoriaModel::find($id);
                $categoria->delete();
                $this->alert('success', 'Datos Eliminados!');
                $this->limpiarDatos();
            }else{
                $this->alert('warning', 'No se puede borrar la categoria');
            }
        }catch(Exception $e){
            $this->alert('warning', 'No se puede borrar la categoria');
        }
    }
   
    public function limpiarDatos()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->foto = null;
        $this->categoria_id = '';
    }
    
}
