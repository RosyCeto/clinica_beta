<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->text('payload');
            $table->integer('last_activity');
            $table->unsignedBigInteger('user_id')->nullable(); // Asegúrate de que esta línea esté presente
            $table->string('ip_address')->nullable(); // Opcional
            $table->text('user_agent')->nullable(); // Opcional
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
