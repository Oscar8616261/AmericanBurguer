<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOfertaModel extends Model
{
    use HasFactory;

    protected $table = 'Detalle_oferta';
    protected $fillable = ['id_oferta','id_producto','precio_final'];
    protected $primaryKey = 'id_det_oferta';
    public $timestamps = true; // ok si quieres que guarde created_at/updated_at

    public function oferta()
    {
        return $this->belongsTo(OfertaModel::class, 'id_oferta', 'id_oferta');
    }

    public function producto()
    {
        return $this->belongsTo(\App\Models\ProductoModel::class, 'id_producto', 'id_producto');
    }
}
