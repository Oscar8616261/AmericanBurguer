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
        Schema::create('Usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre',length:80);
            $table->string('apellidos',length:80);
            $table->string('ci',length:30)->unique();
            $table->string('nombre_usuario',length:80)->unique();
            $table->string('contrasena',length:255);
            $table->enum('tipo', ['administrador', 'personal']);
            $table->string('email',length:80)->unique();
            $table->timestamps();
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
