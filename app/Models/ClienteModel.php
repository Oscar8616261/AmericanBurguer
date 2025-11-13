<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Authenticatable
{
    use Notifiable;
    protected $table = 'Cliente';
    protected $fillable = ['nombre','apellidos','ci','nit','email'];
    protected $primaryKey = 'id_cliente';
    public function isCliente()
    {
        return true;
    }
}
