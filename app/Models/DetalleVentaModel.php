<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVentaModel extends Model
{
    use HasFactory;

    protected $table = 'Detalle_venta';
    protected $primaryKey = 'id_detalle';
    protected $fillable = ['cantidad','precio','efectivo','cambio','id_venta','id_producto'];

    public function producto()
    {
        return $this->belongsTo(ProductoModel::class, 'id_producto', 'id_producto');
    }

    public function venta()
    {
        return $this->belongsTo(VentaModel::class, 'id_venta', 'id_venta');
    }
}

