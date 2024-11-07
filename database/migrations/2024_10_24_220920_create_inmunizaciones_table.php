<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInmunizacionesTable extends Migration
{
    public function up()
    {
        Schema::create('inmunizaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('vacuna_id');
            $table->unsignedBigInteger('dosis_id');
            $table->date('fecha_vacunacion');
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('patients')->onDelete('cascade'); 
            $table->foreign('vacuna_id')->references('id')->on('vacunas')->onDelete('cascade');
            $table->foreign('dosis_id')->references('id')->on('dosis')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inmunizaciones');
    }
}