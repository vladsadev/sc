<?php

use App\Models\EquipmentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            // Relación con tipo de equipo (REQUERIDO)
            $table->foreignIdFor(EquipmentType::class)
                ->constrained()
                ->onDelete('restrict');

            // Información básica (REQUERIDOS)
            $table->string('code', 20)->unique();
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->year('year');

            // Estado (REQUERIDO con valor por defecto)
            $table->enum('status', ['operativa', 'mantenimiento', 'inactiva'])
                ->default('operativa');

            //Ubicación
            $table->enum('location', ['Interior mina', 'Exterior mina', 'Área de Mantenimiento', 'Apartada de la Empresa']);

            // Combustible (OPCIONAL)
            $table->enum('fuel_type', ['diesel', 'gasolina', 'eléctrico'])
                ->nullable()
                ->comment('Tipo de combustible');
            $table->decimal('fuel_capacity', 8, 2)
                ->nullable()
                ->comment('Capacidad de combustible en litros');

            // Campos de mantenimiento (SE LLENAN DESPUÉS, no en creación)
            $table->date('last_maintenance')->nullable();


            // Horas de trabajo (SE ACTUALIZAN EN INSPECCIONES, no en creación)
            $table->decimal('engine_hours', 10, 1)->nullable();
            $table->decimal('percussion_hours', 10, 1)->nullable();
            $table->decimal('position_hours', 10, 1)->nullable();

            // Archivos del equipo (OPCIONALES)
            $table->string('equipment_img')->nullable()->comment('Ruta de la imagen del equipo');

            $table->timestamps();

            // Índices para optimizar consultas
            $table->index(['status', 'equipment_type_id']);
            $table->index('location');
            $table->index('fuel_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
