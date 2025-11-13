<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaModel extends Model
{
    protected $table = 'Oferta';
    protected $fillable = ['nombre','descuento','fecha_ini','fecha_fin','foto'];
    protected $primaryKey = 'id_oferta';
}
