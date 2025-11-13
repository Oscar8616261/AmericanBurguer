<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoModel extends Model
{
    protected $table = 'Producto';
    protected $fillable = ['nombre','precio','stock','descripcion','foto','id_categoria'];
    protected $primaryKey = 'id_producto';

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'id_categoria', 'id_categoria');
    }
}
