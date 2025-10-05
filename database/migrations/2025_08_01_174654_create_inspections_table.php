<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->datetime('inspection_date');
            $table->string('status')->default('completada');
            $table->text('observations')->nullable();


            // SECCIÓN 1: REVISIÓN ANTES DE ARRANCAR EL MOTOR
            $table->boolean('nivel_combustible_checked')->default(false);
            $table->boolean('nivel_aceite_motor_checked')->default(false);
            $table->boolean('nivel_refrigerante_checked')->default(false);
            $table->boolean('nivel_aceite_hidraulico_checked')->default(false);
            $table->boolean('purgar_agua_filtro_checked')->default(false);
            $table->boolean('polvo_valvula_vacio_checked')->default(false);
            $table->boolean('correas_alternador_checked')->default(false);
            $table->boolean('filtro_de_aire_checked')->default(false);
            $table->boolean('reservorio_de_grasa_checked')->default(false);
            $table->boolean('bornes_de_bateria_checked')->default(false);
            $table->boolean('mangueras_de_admision_checked')->default(false);
            $table->boolean('gatas_checked')->default(false);


            // SECCIÓN 2: REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR
            $table->boolean('pedales_freno_checked')->default(false);
            $table->boolean('alarma_arranque_checked')->default(false);
            $table->boolean('viga_y_brazo_checked')->default(false);
            $table->boolean('sistema_de_rimado_checked')->default(false);
            $table->boolean('sistema_de_aire_checked')->default(false);
            $table->boolean('sistema_de_barrido_checked')->default(false);
            $table->boolean('booster_de_agua_checked')->default(false);
            $table->boolean('regulador_de_aire_lub_checked')->default(false);
            $table->boolean('carrete_manguera_agua_checked')->default(false);

            // SECCIÓN 3: INSPECCIÓN GENERAL
            $table->boolean('carrete_de_posicionamiento_checked')->default(false);
            $table->boolean('valvula_a_avance_checked')->default(false);
            $table->boolean('cable_retroceso_y_tensor_checked')->default(false);
            $table->boolean('mesa_de_perforadora_checked')->default(false);
            $table->boolean('dowel_checked')->default(false);

            // SECCIÓN 4: TEMA NO NEGOCIABLES
            $table->boolean('freno_de_servicio_checked')->default(false);
            $table->boolean('freno_parqueo_checked')->default(false);
            $table->boolean('controles_perforacion_checked')->default(false);
            $table->boolean('luces_delanteras_checked')->default(false);
            $table->boolean('alarma_de_retroceso_checked')->default(false);
            $table->boolean('bocina_checked')->default(false);
            $table->boolean('cinturon_de_seguridad_checked')->default(false);
            $table->boolean('switch_master_checked')->default(false);
            $table->boolean('paradas_de_emergencia_checked')->default(false);


            // Horómetros
            $table->decimal('engine_hours', 10, 1);
            $table->decimal('percussion_hours', 10, 1);
            $table->decimal('position_hours', 10, 1);



            //epp
            $table->boolean('epp_complete')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
