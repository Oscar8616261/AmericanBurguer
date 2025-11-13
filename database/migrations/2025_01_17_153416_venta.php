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
        Schema::create('Venta', function (Blueprint $table) {
            $table->id('id_venta');
            $table->date('fecha_venta');
            $table->decimal('total', total: 8, places: 2);

            // ✅ Nuevo campo: estado de la venta
            $table->enum('status', ['pendiente', 'confirmado', 'cancelado'])
                  ->default('pendiente')
                  ->comment('Estado del pedido o venta');

            // Relaciones
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_pago');

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('id_usuario')->references('id_usuario')->on('Usuario')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id_cliente')->on('Cliente')->onDelete('cascade');
            $table->foreign('id_pago')->references('id_pago')->on('Tipo_pago')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Venta');
    }
};
