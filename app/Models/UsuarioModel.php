<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Authenticatable
{
    use Notifiable;
    protected $table = 'Usuario';
    protected $fillable = ['nombre','apellidos','ci','nombre_usuario','contrasena','tipo','email'];
    protected $primaryKey = 'id_usuario';
    public function isUsuario()
    {
        return true;
    }
}
