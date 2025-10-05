<?php

return [
    'sections' => [
        // SECCIÓN 1: REVISIÓN ANTES DE ARRANCAR EL MOTOR
        'revision_antes_arrancar' => [
            'title' => 'REVISIÓN ANTES DE ARRANCAR EL MOTOR',
            'items' => [
                'nivel_combustible' => 'Verificar Nivel De Combustible',
                'nivel_aceite_motor' => 'Verificar El Nivel De Aceite De Motor Diésel',
                'nivel_refrigerante' => 'Verificar El Nivel De Refrigerante',
                'nivel_aceite_hidraulico' => 'Verificar El Nivel De Aceite Hidráulico',
                'purgar_agua_filtro' => 'Purgar Agua Del Filtro Separador',
                'polvo_valvula_vacio' => 'Purgar El Polvo De La Válvula De Vacío Del Filtro De Aire',
                'correas_alternador' => 'Revisar Las Correas Del Alternador, Ventilador Y De Combustible',
                'filtro_de_aire'=> 'Revisar El Filtro De Aire Con El Indicador De Restricción De Admisión',
                'reservorio_de_grasa' => 'Verificar Nivel De Grasa En El Reservorio De Engrase Automático',
                'bornes_de_bateria' => 'Revisar Los Bornes De Las Baterías',
                'mangueras_de_admision' => 'Revisar El Estado De Mangueras Flexibles De Admisión',
                'gatas'=> 'Gatas delanteras y posteriores'
            ]
        ],

        // SECCIÓN 2: REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR
        'revision_despues_arrancar' => [
            'title' => 'REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR',
            'items' => [
                'pedales_freno' => 'Verificar Funcionamiento De Los Pedales De Freno Y Aceleración',
                'alarma_arranque' => 'Verificar funcionalidad de Alarma de arranque con zumbador',
                'viga_y_brazo' => 'Verificar funcionalidad de posicionamiento de viga y brazo',
                'sistema_de_rimado' => 'Verificar funcionalidad del Sistema de Rimado',
                'sistema_de_aire' => 'Verificar funcionalidad del Sistema de Aire',
                'sistema_de_barrido' => 'Verificar funcionalidad del  Sistema de Barrido Mixto ',
                'booster_de_agua' => 'Verificar funcionalidad del  Booster de agua',
                'regulador_de_aire_lub' => 'Funcionamiento regulador de aire para lubricación',
                'carrete_manguera_agua' => 'Verificar funcionalidad del Carrete de manguera de agua '

            ]
        ],

        // SECCIÓN 3: INSPECCIÓN GENERAL
        'inspeccion_general' => [
            'title' => 'INSPECCIÓN GENERAL',
            'items' => [
                'carrete_de_posicionamiento' => 'Verificación de carretes hidráulicos de posicionamiento, sujeción y articulation ',
                'valvula_a_avance' => 'Verificación válvula de antiparalelismo y avance ',
                'cable_retroceso_y_tensor' => 'Verificación de cable de tracción, retroceso y tensor de cable de retorno',
                'mesa_de_perforadora' => 'Mesa de perforadora, deslizaderas de viga y Holder de mesa de perforadora',
                'dowel' => 'Tope delantero ( dowel)',
            ]
        ],

        // SECCIÓN 4: TEMA NO NEGOCIABLES (ANTES DE MOVER EL EQUIPO)
        'temas_no_negociables' => [
            'title' => 'TEMA NO NEGOCIABLES (ANTES DE MOVER EL EQUIPO)',
            'items' => [
                'freno_de_servicio' => 'Revisión de freno de servicio',
                'freno_parqueo' => 'Revisión de freno de parqueo',
                'controles_perforacion' => 'Controles de operación para perforación',
                'luces_delanteras' => 'Verificación de luces delanteras',
                'alarma_de_retroceso' => 'Verificación de alarma de retroceso',
                'bocina' => 'Verificación de bocina',
                'cinturon_de_seguridad'=>'Verificación del cinturón de seguridad',
                'switch_master'=>'Verificación bloqueo de energía (Switch Master)',
                'paradas_de_emergencia' => 'Verificación de Paradas de emergencia'
            ]
        ],
    ],

    // Configuración adicional
    'settings' => [
        'require_all_items' =>false, // Todos los items son obligatorios
        'allow_partial_sections' => false, // No permitir secciones parciales
        'show_progress_by_section' =>true, // Mostrar progreso por sección
    ]
];
