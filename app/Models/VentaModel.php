<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaModel extends Model
{
    use HasFactory;

    protected $table = 'Venta';
    protected $fillable = ['fecha_venta','total','status','id_usuario','id_cliente','id_pago'];
    protected $primaryKey = 'id_venta';

    public function detalles()
    {
        return $this->hasMany(DetalleVentaModel::class, 'id_venta', 'id_venta');
    }

    public function cliente()
    {
        return $this->belongsTo(ClienteModel::class, 'id_cliente', 'id_cliente');
    }
}
