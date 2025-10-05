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
        Schema::create('manuals', function (Blueprint $table) {
            $table->id();

            // Tipo de equipo - guardamos el nombre directamente para evitar problemas si cambia el índice
            $table->string('equipment_type', 50);
            $table->index('equipment_type'); // Índice para búsquedas rápidas

            // Modelo del equipo
            $table->string('model', 100);
            $table->index('model'); // Índice para búsquedas rápidas

            // Tipo de manual (partes, diagrama, seguridad, operación, mantenimiento)
            $table->string('manual_type', 50); // Cambié 'description' por 'manual_type' para mayor claridad
            $table->index('manual_type');

            // Versión del manual
            $table->string('version', 20)->nullable();

            // Ruta del archivo PDF
            $table->string('file_path');

            // Nombre original del archivo
            $table->string('original_filename');

            // Tamaño del archivo en bytes
            $table->unsignedBigInteger('file_size');

            // Hash del archivo para detectar duplicados
            $table->string('file_hash', 64)->nullable();
            $table->index('file_hash');

            // Notas o comentarios
            $table->text('notes')->nullable();

            // Usuario que subió el manual
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('restrict');

            // Usuario que actualizó por última vez
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('restrict');

            // Contador de descargas
            $table->unsignedInteger('download_count')->default(0);

            // Estado del manual
            $table->enum('status', ['active', 'archived', 'pending'])->default('active');
            $table->index('status');

            // Fecha de publicación del manual (puede ser diferente a created_at)
            $table->date('published_date')->nullable();

            $table->timestamps();

            // Índice compuesto para búsquedas comunes
            $table->index(['equipment_type', 'model', 'manual_type']);

            // Índice único para evitar duplicados exactos
            $table->unique(['equipment_type', 'model', 'manual_type', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manuals');
    }
};
