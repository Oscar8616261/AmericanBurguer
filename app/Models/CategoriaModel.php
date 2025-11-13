<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    protected $table = 'Catagoria';
    protected $fillable = ['nombre','descripcion','foto'];
    protected $primaryKey = 'id_categoria';

    public function productos()
    {
        return $this->hasMany(ProductoModel::class, 'id_categoria', 'id_categoria');
    }
}
