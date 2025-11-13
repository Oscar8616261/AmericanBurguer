<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmpresaModel;
use Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ListaEmpresa extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $search='';
    public $showModal=false;

    public $nombre = '';
    public $direccion = '';
    public $latLog = '';
    public $empresa_id='';
    protected function rules(){
        $rules = [
            'nombre' => 'required',
            'direccion' => 'required',
            'latLog' => 'required',
        ];
        return $rules;
    }

    public function clickBuscar(){

    }
    public function limpiarDatos(){
        $this->nombre = '';
        $this->direccion = '';
        $this->latLog = '';
        $this->empresa_id='';
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
        $empresas = EmpresaModel::where('nombre','like','%'.$this->search.'%')->paginate(6);
        return view('livewire.lista-empresa',compact('empresas'));
    }
    public function enviarClick()
    {
        $this->validate();
        if($this->empresa_id){
            $empresa = EmpresaModel::find($this->empresa_id);
            $empresa->update([
                'nombre' => $this->nombre,
                'direccion' => $this->direccion,
                'latLog' => $this->latLog,
            ]);
        }else{
            EmpresaModel::create([
                'nombre' => $this->nombre,
                'direccion' => $this->direccion,
                'latLog' => $this->latLog,
            ]);
        }
        $this->alert('success', 'Datos Guardados!');
        $this->limpiarDatos();
        $this->closeModal();
    }
    public function editar($id){
        $empresa = EmpresaModel::find($id);
        $this->nombre = $empresa->nombre;
        $this->direccion = $empresa->direccion;
        $this->latLog = $empresa->latLog;
        $this->empresa_id = $id;
        $this->openModal();
    }
    public function delete($id){
        try{
            $empresa = EmpresaModel::find($id);
            $empresa->delete();
            $this->alert('success', 'Datos Eliminados!');
            $this->limpiarDatos();
        }catch(Exception $e){
            $this->alert('error', 'No se puede eliminar el registro!');
        }
    }
}
