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
        Schema::create('Extra', function (Blueprint $table) {
            $table->id('id_extra');
            $table->string('nombre',length:80);
            $table->decimal('precio',total:8,places:2);
            $table->string('codigo',length:30)->unique();
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
