<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\CategoriaModel;
use \App\Models\ProductoModel;
use App\Models\EstrellasModel;
use App\Models\DetalleVentaModel;
use Illuminate\Support\Facades\Auth;
use Alert;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class ListaProductos extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;
    public $search='';
    public $showModal=false;
    public $showModal2=false;

    public $nombre = '';
    public $descripcion = '';
    public $precio = '';
    public $stock = '';
    public $categoria = '';
    public $foto; 
    public $producto_id='';
    public $puntuacion=0;

    protected function rules(){
        $rules = [
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'required',
            'categoria' => 'required',
        ];
        
        if (($this->producto_id && is_object($this->foto)) ){
            $rules['foto']=['image','max:10024'];
        }
        else if($this->producto_id=='')
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
    public function openModal2(){
        $this->showModal2=true;
    }
    public function closeModal2(){
        $this->showModal2=false;
        $this->limpiarDatos();
    }
    public function calificar($id){
        $this->openModal2();
        $this->producto_id = $id;
    }
    public function seleccionarEstrella($valor)
    {
        $this->puntuacion = $valor;
    }

    public function guardarCalificacion()
    {
        $this->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        EstrellasModel::create([
            'id_producto' => $this->producto_id,
            'id_cliente' => Auth::guard('clientes')->id(),
            'puntuacion' => $this->puntuacion,
        ]);

        $this->closeModal2();
        $this->alert('success', 'Calificación Guardada!');
        
    }
    public function render()
    {
        $categorias = CategoriaModel::all();
        $productos = ProductoModel::where('nombre','like','%'.$this->search.'%')
        ->paginate(6);

        $productos->getCollection()->transform(function ($producto) {
            $puntuaciones = EstrellasModel::where('id_producto', $producto->id_producto)->pluck('puntuacion');
            
            $producto->promedio_estrellas = $puntuaciones->count() > 0 ? round($puntuaciones->avg()) : 0;
            return $producto;
        });
        return view('livewire.lista-productos',compact('productos'),compact('categorias'));
    }
    public function enviarClick()
    {
        $this->validate();
        if($this->producto_id){
            $producto = ProductoModel::find($this->producto_id);
            $producto->nombre = $this->nombre;
            $producto->precio = $this->precio;
            $producto->stock =  intval($this->stock);
            $producto->descripcion = $this->descripcion;
            $producto->id_categoria =  intval($this->categoria);
            if ($this->foto && is_object($this->foto)) {
                $filename = time() . '_' . $this->foto->getClientOriginalName();
                $this->foto->storeAs('img', $filename, 'public');
                $producto->foto = $filename;
            }
            $producto->save();
            $this->producto_id = '';
        }else{
        
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
        }
        $this->alert('success', 'Datos Guardados!');
        $this->limpiarDatos();
       $this->closeModal();
    }

    public function editar($id){
        
        $producto = ProductoModel::find($id);
        $this->nombre = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->precio = $producto->precio;
        $this->stock = $producto->stock;
        $this->categoria = $producto->id_categoria;
        if (!$this->foto) {
            $this->foto = $producto->foto;
        }
        
        $this->producto_id = $id;
        $this->openModal();
    }

    public function delete($id){
        try{
            $s= EstrellasModel::where('id_producto',$id)->get();
            $v= DetalleVentaModel::where('id_producto',$id)->get();
            if(count($s)==0 && count($v)==0){
                $producto = ProductoModel::find($id);
                $producto->delete();
                $this->alert('success', 'Producto Eliminado!');
                $this->limpiarDatos();
            }else{
                $this->alert('warning', 'No se puede borrar el producto');
            }
        }catch(Exception $e){
            $this->alert('error', 'No se puede eliminar el producto');
        }
    }
    public function limpiarDatos(){
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio = '';
        $this->stock = '';
        $this->categoria = '';
        $this->foto = null;
        $this->producto_id = '';
        $this->puntuacion = null;
    }
}
