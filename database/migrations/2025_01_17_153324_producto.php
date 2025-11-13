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
        Schema::create('Catagoria', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre',length:80);
            $table->string('descripcion',length:200);
            $table->string('foto',length:80);
            $table->timestamps();
        });
        Schema::create('Producto', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre',length:80);
            $table->decimal('precio',total:8,places:2);
            $table->integer('stock')->default(0);
            $table->string('descripcion',length:200);
            $table->string('foto',length:80);
            $table->unsignedBigInteger('id_categoria');
            $table->timestamps();

            $table->foreign('id_categoria')->references('id_categoria')->on('Catagoria');
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
