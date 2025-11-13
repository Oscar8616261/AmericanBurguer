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
        Schema::create('Cliente', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nombre',length:80);
            $table->string('apellidos',length:80);
            $table->string('ci',length:30)->unique();
            $table->string('nit',length:30)->unique();
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
