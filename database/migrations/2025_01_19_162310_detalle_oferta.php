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
        Schema::create('detalle_oferta', function (Blueprint $table) {
            $table->id('id_det_oferta');
            $table->unsignedBigInteger('id_producto');
            $table->decimal('precio',total:8,places:2);
            $table->integer('cantidad');
            $table->timestamps();

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
