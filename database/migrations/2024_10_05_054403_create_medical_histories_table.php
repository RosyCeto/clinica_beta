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
    Schema::create('medical_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        $table->enum('type_consult', ['primera consulta', 'consulta general']);
        $table->text('consultation_reason')->nullable();
        $table->text('current_illness_history')->nullable();
        $table->text('personal_history')->nullable();
        $table->text('family_history')->nullable();
        $table->text('habits_history')->nullable();
        $table->text('allergies')->nullable();
        $table->text('vital_signs');
        $table->float('weight');
        $table->float('height');
        $table->text('diagnosis_treatment');
        $table->text('comments');
        $table->timestamps(); 
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};