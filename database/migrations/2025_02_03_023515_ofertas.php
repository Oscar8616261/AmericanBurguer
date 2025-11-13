<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Oferta', function (Blueprint $table) {
            $table->id('id_oferta');
            $table->string('nombre',length:80);
            $table->decimal('descuento',total:8,places:2);
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->string('foto',length:80);
            $table->timestamps();
        });
        Schema::create('Detalle_oferta', function (Blueprint $table) {
            $table->id('id_det_oferta');
            $table->unsignedBigInteger('id_oferta');
            $table->unsignedBigInteger('id_producto');
            $table->decimal('precio_final',total:8,places:2);
            $table->timestamps();

            $table->foreign('id_oferta')->references('id_oferta')->on('Oferta');
            $table->foreign('id_producto')->references('id_producto')->on('Producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
