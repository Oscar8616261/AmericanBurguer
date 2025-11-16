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
        // Usuarios
        Schema::create('Usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 80);
            $table->string('apellidos', 80);
            $table->string('ci', 30)->unique();
            $table->string('nombre_usuario', 80)->unique();
            $table->string('contrasena', 255);
            $table->enum('tipo', ['administrador', 'personal']);
            $table->string('email', 80)->unique();
            $table->timestamps();
        });

        // Clientes
        Schema::create('Cliente', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nombre', 80);
            $table->string('apellidos', 80);
            $table->string('ci', 30)->unique();
            $table->string('direccion', 80);
            $table->string('email', 80)->unique();
            $table->timestamps();
        });

        // Categoria (tal como la llamaste: Catagoria)
        Schema::create('Catagoria', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre', 80);
            $table->string('descripcion', 200);
            $table->string('foto', 80);
            $table->timestamps();
        });

        // Producto (depende de Catagoria)
        Schema::create('Producto', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre', 80);
            $table->decimal('precio', 8, 2);
            $table->integer('stock')->default(0);
            $table->string('descripcion', 200);
            $table->string('foto', 80);
            $table->enum('status', ['fuera de stock', 'disponible', 'oferta']);
            $table->unsignedBigInteger('id_categoria');
            $table->timestamps();

            $table->foreign('id_categoria')->references('id_categoria')->on('Catagoria')->onDelete('cascade');
        });

        // Tipo de pago
        Schema::create('Tipo_pago', function (Blueprint $table) {
            $table->id('id_pago');
            $table->string('nombre', 80);
            $table->timestamps();
        });

        // Venta (depende de Usuario, Cliente, Tipo_pago)
        Schema::create('Venta', function (Blueprint $table) {
            $table->id('id_venta');
            $table->date('fecha_venta');
            $table->decimal('total', 8, 2);

            $table->enum('status', ['pendiente', 'confirmado', 'cancelado'])
                  ->default('pendiente')
                  ->comment('Estado del pedido o venta');

            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_pago');

            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('Usuario')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id_cliente')->on('Cliente')->onDelete('cascade');
            $table->foreign('id_pago')->references('id_pago')->on('Tipo_pago')->onDelete('cascade');
        });

        // Detalle de venta (depende de Venta y Producto)
        Schema::create('Detalle_venta', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->integer('cantidad')->default(0);
            $table->decimal('precio', 8, 2);
            $table->decimal('efectivo', 8, 2);
            $table->decimal('cambio', 8, 2);

            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_producto');

            $table->timestamps();

            $table->foreign('id_venta')->references('id_venta')->on('Venta')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('Producto')->onDelete('cascade');
        });

        // Estrellas (reseñas/puntuaciones) (depende de Producto y Cliente)
        Schema::create('Estrellas', function (Blueprint $table) {
            $table->id('id_estrella');
            $table->integer('puntuacion');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_cliente');
            $table->timestamps();

            $table->foreign('id_producto')->references('id_producto')->on('Producto')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id_cliente')->on('Cliente')->onDelete('cascade');
        });

        // Oferta y detalle de oferta
        Schema::create('Oferta', function (Blueprint $table) {
            $table->id('id_oferta');
            $table->string('nombre', 80);
            $table->decimal('descuento', 8, 2);
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->string('foto', 80);
            $table->timestamps();
        });

        Schema::create('Detalle_oferta', function (Blueprint $table) {
            $table->id('id_det_oferta');
            $table->unsignedBigInteger('id_oferta');
            $table->unsignedBigInteger('id_producto');
            $table->decimal('precio_final', 8, 2);
            $table->timestamps();

            $table->foreign('id_oferta')->references('id_oferta')->on('Oferta')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('Producto')->onDelete('cascade');
        });

        // Empresa
        Schema::create('Empresa', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('nombre', 80);
            $table->string('direccion', 80);
            $table->string('latLog', 80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop en orden inverso para evitar errores por foreign keys
        Schema::dropIfExists('Detalle_oferta');
        Schema::dropIfExists('Oferta');
        Schema::dropIfExists('Estrellas');
        Schema::dropIfExists('Detalle_venta');
        Schema::dropIfExists('Venta');
        Schema::dropIfExists('Tipo_pago');
        Schema::dropIfExists('Producto');
        Schema::dropIfExists('Catagoria');
        Schema::dropIfExists('Empresa');
        Schema::dropIfExists('Cliente');
        Schema::dropIfExists('Usuario');
    }
};
