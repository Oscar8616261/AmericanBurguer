<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPagoModel extends Model
{
    protected $table = 'Tipo_pago';
    protected $fillable = ['nombre'];
    protected $primaryKey = 'id_pago';
}
