<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOfertaModel extends Model
{
    protected $table = 'Detalle_oferta';
    protected $fillable = ['id_oferta','id_producto','precio_final'];
    protected $primaryKey = 'id_det_oferta';
}
