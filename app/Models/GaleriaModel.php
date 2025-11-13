<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriaModel extends Model
{
    protected $table = 'Galeria';
    protected $fillable = ['foto'];
    protected $primaryKey = 'id_galeria';
}
