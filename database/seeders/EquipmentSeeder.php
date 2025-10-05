<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Crear los 3 tipos de equipos específicos
//        $excavadora = EquipmentType::factory()->excavadora()->create();
        $acarreo = EquipmentType::factory()->acarreo()->create();
        $perforadora = EquipmentType::factory()->perforadora()->create();

        // Crear equipos con especificaciones realistas por tipo


        //  Camiones con especificaciones de acarreo
        Equipment::factory(2)
            ->acarreo()
            ->create(['equipment_type_id' => $acarreo->id]);
//
        //  Perforadoras con especificaciones de perforadora
        Equipment::factory(2)
            ->perforadora()
            ->create(['equipment_type_id' => $perforadora->id]);

    }
}
