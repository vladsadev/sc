<?php

namespace Database\Factories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'equipment_type_id' => EquipmentType::factory(),
            'code' => $this->generateEquipmentCode(),
            'brand' => $this->faker->randomElement(['Caterpillar', 'Epiroc', 'Komatsu', 'Liebherr', 'Epiroc', 'Volvo']),
            'model' => $this->faker->randomElement(['Simba S7', 'XT200', 'JJ300', 'R9800', 'PC8000']),
            'year' => $this->faker->numberBetween(2015, 2025),
            'status' => $this->faker->randomElement(['operativa', 'mantenimiento', 'inactiva']),
            'location' => $this->faker->randomElement(['Interior mina', 'Exterior mina','Área de Mantenimiento']),

            'fuel_type' => $this->faker->randomElement(['diesel', 'electrico', 'hibrido']),

            // Capacidades
            'fuel_capacity' => $this->faker->randomFloat(2, 300, 1000), // Litros

            'last_maintenance' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
//            'next_maintenance' => $this->faker->optional()->dateTimeBetween('now', '+3 months'),
        ];
    }

    private function generateEquipmentCode(): string
    {
        $prefixes = ['CAM', 'PER'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);

        return $prefix . '-' . $number;
    }

    public function acarreo(): static
    {
        return $this->state(fn(array $attributes) => [
            'fuel_type' => $this->faker->randomElement(['diesel', 'electrico']),
        ]);
    }

    public function perforadora(): static
    {
        return $this->state(fn(array $attributes) => [
            'fuel_type' => $this->faker->randomElement(['diesel', 'electrico']),
        ]);
    }
}
