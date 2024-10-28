<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Asegura que el nombre sea único
            $table->text('descripcion')->nullable();
            $table->string('codigo')->unique(); // Añadir el campo 'codigo' asegurando que sea único
            $table->integer('cantidad')->default(0); // Establece un valor por defecto de 0
            $table->date('fecha_caducidad');
            $table->timestamps();

            // Índice para fecha de caducidad
            $table->index('fecha_caducidad');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medications');
    }
};
