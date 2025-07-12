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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('blood_type_id')->nullable()->constrained('blood_types')->onDelete('set null');
            $table->timestamps();
            $table->string('allergies')->nullable(); // Alergias del paciente
            $table->string('chronic_conditions')->nullable(); // Condiciones crónicas del paciente
            $table->text('surgical_history')->nullable(); // Historial médico del paciente
            $table->string('family_history')->nullable(); // Historial familiar del paciente
            $table->string('observations')->nullable(); // Observaciones adicionales sobre el paciente
            $table->string('emergency_contact_name')->nullable(); // Nombre del contacto de emergencia
            $table->string('emergency_contact_relationship')->nullable(); // Relación con el contacto de emergencia
            $table->string('emergency_contact_phone')->nullable(); // Teléfono del contacto de emergencia
            $table->date('date_of_birth')->nullable(); // Fecha de nacimiento del paciente
            $table->string('photo')->nullable(); // Foto del paciente (opcional))
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
