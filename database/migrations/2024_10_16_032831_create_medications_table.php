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
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('codigo');
            $table->integer('cantidad')->default(0); 
            $table->date('fecha_caducidad');
            $table->date('fecha_ingreso')->default(now());
            $table->timestamps();

            $table->index('fecha_caducidad');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medications');
    }
};