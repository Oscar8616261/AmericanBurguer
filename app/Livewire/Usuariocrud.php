<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UsuarioModel;
use App\Models\VentaModel;
use Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Usuariocrud extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $search='';
    public $showModal=false;

    public $nombre = '';
    public $apellidos = '';
    public $ci = '';
    public $nombre_usuario = '';
    public $contrasena = '';
    public $tipo = '';
    public $email = '';
    public $usuario_id='';

    protected function rules(){
        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required',
            'ci' => 'required|min:3',
            'nombre_usuario' => 'required',
            'contrasena' => 'required',
            'tipo' => 'required',
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
        $this->nombre_usuario = '';
        $this->contrasena = '';
        $this->tipo = '';
        $this->email = '';
        $this->usuario_id='';
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
        $usuarios = UsuarioModel::where('nombre','like','%'.$this->search.'%')->paginate(6);
        return view('livewire.usuariocrud',compact('usuarios'));
    }
    public function enviarClick()
    {
        $this->validate();
        if($this->usuario_id){
            $usuario = UsuarioModel::find($this->usuario_id);
            $usuario->update([
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'ci' => $this->ci,
                'nombre_usuario' => $this->nombre_usuario,
                'contrasena' => $this->contrasena,
                'tipo' => $this->tipo,
                'email' => $this->email,
            ]);
        }else{
            UsuarioModel::create([
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'ci' => $this->ci,
                'nombre_usuario' => $this->nombre_usuario,
                'contrasena' => $this->contrasena,
                'tipo' => $this->tipo,
                'email' => $this->email,
            ]);
        }
        $this->alert('success', 'Datos Guardados!');
        $this->limpiarDatos();
        $this->closeModal();
    }
    public function editar($id){
        $usuario = UsuarioModel::find($id);
        $this->nombre = $usuario->nombre;
        $this->apellidos = $usuario->apellidos;
        $this->ci = $usuario->ci;
        $this->nombre_usuario = $usuario->nombre_usuario;
        $this->contrasena = $usuario->contrasena;
        $this->tipo = $usuario->tipo;
        $this->email = $usuario->email;
        $this->usuario_id = $id;
        $this->openModal();
    }
    public function delete($id){
        try{
            $v= VentaModel::where('id_usuario',$id)->get();
            if(count($v)==0){
                $usuario = UsuarioModel::find($id);
                $usuario->delete();
                $this->alert('success', 'Usuario Eliminado!');
                $this->limpiarDatos();
            }else{
                $this->alert('warning', 'No se puede borrar el Usuario');
            }
        }catch(Exception $e){
            $this->alert('error', 'No se puede eliminar el Usuario');
        }
    }
}
