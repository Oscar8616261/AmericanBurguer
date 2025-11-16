<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClienteModel;
use App\Models\VentaModel;
use App\Models\EstrellasModel;
use Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ListaCliente extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $search='';
    public $showModal=false;

    public $nombre = '';
    public $apellidos = '';
    public $ci = '';
    public $direccion = '';
    public $email = '';
    public $cliente_id='';

    protected function rules(){
        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required|min:3',
            'ci' => 'required|min:3',
            'direccion' => 'required',
            'email' => 'required|email',
        ];
        return $rules;
    }
    public function clickBuscar(){

    }
    public function limpiarDatos(){
        $this->nombre = '';
        $this->apellidos = '';
        $this->ci = '';
        $this->direccion = '';
        $this->email = '';
        $this->cliente_id='';
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
        $clientes = ClienteModel::where('nombre','like','%'.$this->search.'%')->paginate(6);
        return view('livewire.lista-cliente',compact('clientes'));
    }
    public function enviarClick()
    {
        $this->validate();
        if($this->cliente_id){
            $cliente = ClienteModel::find($this->cliente_id);
            $cliente->update([
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'ci' => $this->ci,
                'direccion' => $this->direccion,
                'email' => $this->email,
            ]);
        }else{
            ClienteModel::create([
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'ci' => $this->ci,
                'direccion' => $this->direccion,
                'email' => $this->email,
            ]);
        }
        $this->alert('success', 'Datos Guardados!');
        $this->limpiarDatos();
        $this->closeModal();
    }
    public function editar($id){
        $cliente = ClienteModel::find($id);
        $this->nombre = $cliente->nombre;
        $this->apellidos = $cliente->apellidos;
        $this->ci = $cliente->ci;
        $this->direccion = $cliente->direccion;
        $this->email = $cliente->email;
        $this->cliente_id = $id;
        $this->openModal();
    }
    public function delete($id){
        try{
            $s= EstrellasModel::where('id_cliente',$id)->get();
            $v= VentaModel::where('id_cliente',$id)->get();
            if(count($s)==0 && count($v)==0){
                $cliente = ClienteModel::find($id);
                $cliente->delete();
                $this->alert('success', 'Cliente Eliminado!');
                $this->limpiarDatos();
            }else{
                $this->alert('warning', 'No se puede borrar el Cliente');
            }
        }catch(Exception $e){
            $this->alert('error', 'No se puede eliminar el Cliente');
        }
    }
}
