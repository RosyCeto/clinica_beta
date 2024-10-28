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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('patients')->onDelete('cascade'); // Asegúrate de que el nombre de la tabla sea 'patients'
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade'); // Verifica que 'medicos' sea el nombre correcto
            $table->dateTime('fecha');
            $table->string('status')->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
};
