<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\OfertaModel;
use App\Models\DetalleOfertaModel;
use Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Ofertascrud extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;
    public $search='';
    public $showModal=false;

    public $nombre = '';
    public $descuento = '';
    public $fecha_ini = '';
    public $fecha_fin = '';
    public $foto;
    public $oferta_id='';

    protected function rules(){
        $rules = [
            'nombre' => 'required',
            'descuento' => 'required|numeric|min:0',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required',
        ];
        if (($this->oferta_id && is_object($this->foto)) ){
            $rules['foto']=['image','max:10024'];
        }
        else if($this->oferta_id=='')
            $rules['foto']=['image','max:10024'];
        return $rules;
    }

    public function clickBuscar(){

    }
    public function limpiarDatos(){
        $this->nombre = '';
        $this->descuento = '';
        $this->fecha_ini = '';
        $this->fecha_fin = '';
        $this->foto = null;
        $this->oferta_id='';
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
        $ofertas = OfertaModel::where('nombre','like','%'.$this->search.'%')->paginate(6);
        return view('livewire.ofertascrud',compact('ofertas'));
    }
    public function enviarClick()
    {
        $this->validate();
        if($this->oferta_id){
            $oferta = OfertaModel::find($this->oferta_id);
            $oferta->nombre = $this->nombre;
            $oferta->descuento = $this->descuento;
            $oferta->fecha_ini = $this->fecha_ini;
            $oferta->fecha_fin = $this->fecha_fin;
            if ($this->foto && is_object($this->foto)) {
                $filename = time() . '_' . $this->foto->getClientOriginalName();
                $this->foto->storeAs('img', $filename, 'public');
                $oferta->foto = $filename;
            }
            $oferta->save();
            $this->oferta_id = '';
        }
        else{
            $filename = time() . '_' . $this->foto->getClientOriginalName();

            $this->foto->storeAs('img', $filename, 'public');
            OfertaModel::create([
                'nombre' => $this->nombre,
                'descuento' => $this->descuento,
                'fecha_ini' => $this->fecha_ini,
                'fecha_fin' => $this->fecha_fin,
                'foto' => $filename,
            ]);
        }
        $this->alert('success', 'Datos Guardados!');
        $this->limpiarDatos();
        $this->closeModal();
    }
    public function editar($id){
        $oferta = OfertaModel::find($id);
        $this->nombre = $oferta->nombre;
        $this->descuento = $oferta->descuento;
        $this->fecha_ini = $oferta->fecha_ini;
        $this->fecha_fin = $oferta->fecha_fin;
        if (!$this->foto) {
            $this->foto = $oferta->foto;
        }
        $this->oferta_id = $id;
        $this->openModal();
    }
    public function delete($id){
        try{
            $o= DetalleOfertaModel::where('id_oferta',$id)->get();
            if(count($o)==0){
                $oferta = OfertaModel::find($id);
                $oferta->delete();
                $this->alert('success', 'Oferta Eliminada!');
                $this->limpiarDatos();
            }else{
                $this->alert('warning', 'No se puede borrar la oferta');
            }
        }catch(Exception $e){
            $this->alert('error', 'No se puede eliminar la oferta');
        }
    }
}
