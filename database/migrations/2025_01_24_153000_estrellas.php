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
        Schema::create('Estrellas', function (Blueprint $table) {
            $table->id('id_estrella');
            $table->integer('puntuacion');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_cliente');
            $table->timestamps();

            $table->foreign('id_producto')->references('id_producto')->on('Producto');
            $table->foreign('id_cliente')->references('id_cliente')->on('Cliente');
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
