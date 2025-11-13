<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstrellasModel extends Model
{
    protected $table = 'Estrellas';
    protected $fillable = ['puntuacion','id_producto','id_cliente'];
    protected $primaryKey = 'id_estrella';
}
