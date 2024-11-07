<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->timestamp('fecha_registro')->nullable()->default(null);
        $table->string('foto')->nullable();
        $table->boolean('status')->default(true);
    });
}


public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('fecha_registro');
        $table->dropColumn('foto');
        $table->dropColumn('status');
    });
}

};