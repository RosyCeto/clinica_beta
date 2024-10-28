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
    Schema::create('patients', function (Blueprint $table) {
        $table->id(); 
        $table->string('cui', 13)->nullable()->unique()->index();
        $table->string('nexpedientes', 255)->index();
        $table->string('primer_nombre', 200); 
        $table->string('segundo_nombre', 200)->nullable();
        $table->string('primer_apellido', 200); 
        $table->string('segundo_apellido', 200)->nullable(); 
        $table->string('apellido_casada', 200)->nullable();
        $table->enum('gender', ['masculino', 'femenino']);
        $table->enum('etnia', ['ladina', 'maya', 'xinca', 'garifuna', 'other']); 
        $table->date('fecha_nacimiento'); 
        $table->string('edad', 200);
        $table->longText('discapacidad')->nullable();
        $table->enum('escolaridad', ['N/A', 'preprimaria', 'primaria', 'basico', 'diversificado', 'universidad', 'otro']); 
        $table->string('profesion', 250)->nullable();
        $table->string('telefono', 8)->nullable(); 
        $table->text('direccion')->nullable(); // Cambiar a text si es necesario
        $table->timestamps(); 
    });
}

    
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
