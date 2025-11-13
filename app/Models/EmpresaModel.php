<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaModel extends Model
{
    protected $table = 'Empresa';
    protected $fillable = ['nombre','direccion','latLog'];
    protected $primaryKey = 'id_empresa';
}
