<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resultados_laboratorio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('realizar_examen_id');
            $table->string('archivo');  // Añadir el campo de archivo
            $table->text('comentarios')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->enum('estado', ['pendiente', 'finalizado'])->default('pendiente');
            $table->timestamps();
        
            $table->foreign('realizar_examen_id')->references('id')->on('realizar_examenes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('resultados_laboratorio');
    }
};