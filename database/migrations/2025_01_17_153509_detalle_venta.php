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
        Schema::create('Detalle_venta', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->integer('cantidad')->default(0);
            $table->decimal('precio', total: 8, places: 2);
            $table->decimal('efectivo', total: 8, places: 2);
            $table->decimal('cambio', total: 8, places: 2);

            // Relaciones
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_producto');

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('id_venta')->references('id_venta')->on('Venta')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('Producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Detalle_venta');
    }
};
