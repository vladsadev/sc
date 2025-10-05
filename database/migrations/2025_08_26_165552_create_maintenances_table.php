<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Quien programa/ejecuta

            // Tipo y estado del mantenimiento
            $table->enum('type', ['preventivo', 'correctivo', 'emergencia'])
                ->default('preventivo');

            // Fechas importantes
            $table->date('scheduled_date'); // Fecha programada

            // Detalles del mantenimiento
            $table->string('title')->nullable(); // Ej: "Cambio de aceite motor"
            $table->text('description')->nullable();
            $table->text('observations')->nullable();

            // Recursos utilizados
            $table->integer('duration_hours')->nullable(); // Duración en horas

            $table->timestamps();

            // Índices
            $table->index(['equipment_id', 'scheduled_date']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
