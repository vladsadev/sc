<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


//        User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Pepe',
//            'email' => 'pepe@pp.com',
//            'password' => '1524780032',
//            'is_admin' => 1
//        ]);
//        User::factory()->create([
//            'name' => 'Carlangas',
//            'email' => 'cc@cc.com',
//            'password' => '1524780032',
//            'is_admin' => 1
//        ]);

        User::create([
            'name' => 'Pepe',
            'email' => 'pepe@pp.com',
            'password' => '1524780032',
            'is_admin' => 1
        ]);
        User::create([
            'name' => 'Carlangas',
            'email' => 'cc@cc.com',
            'password' => '1524780032',
            'is_admin' => 1
        ]);
//        $this->call(EquipmentSeeder::class);
        EquipmentType::factory()->acarreo()->create();
        EquipmentType::factory()->perforadora()->create();

    }
}
