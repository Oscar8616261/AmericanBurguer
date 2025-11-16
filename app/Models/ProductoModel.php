<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductoModel extends Model
{
    use HasFactory;

    protected $table = 'Producto';
    protected $fillable = ['nombre','precio','stock','descripcion','foto','status','id_categoria'];
    protected $primaryKey = 'id_producto';
    public $timestamps = true;

    // Constantes de estado
    public const STATUS_DISPONIBLE = 'disponible';
    public const STATUS_FUERA = 'fuera de stock';
    public const STATUS_OFERTA = 'oferta';
    public const STATUS_BAJA = 'baja';

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'id_categoria', 'id_categoria');
    }

    /**
     * Comprueba si el producto tiene oferta (usa la tabla Detalle_oferta).
     */
    public function hasOffer(): bool
    {
        return DB::table('Detalle_oferta')->where('id_producto', $this->id_producto)->exists();
    }

    /**
     * Actualiza automáticamente el estado según stock/oferta.
     */
    public function updateStatusByStockAndOffer()
    {
        // Si el estado es manualmente 'baja', no lo sobreescribimos aquí.
        if ($this->status === self::STATUS_BAJA) {
            return $this->save();
        }

        if ($this->stock <= 0) {
            $this->status = self::STATUS_FUERA;
        } elseif ($this->hasOffer()) {
            $this->status = self::STATUS_OFERTA;
        } else {
            $this->status = self::STATUS_DISPONIBLE;
        }

        return $this->save();
    }
}
