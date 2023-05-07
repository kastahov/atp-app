<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'driver_id' => User::factory()->create(['role' => 'driver']),
            'brand' => $this->faker->randomElement([
                'Volvo',
                'Audi',
                'Mercedes',
                'BMW',
                'Scania',
                'Toyota',
                'Hyundai',
                'Chery',
                'Lotus',
            ]),
            'model' => $this->faker->randomElement([
                'XC90',
                'CC',
                'BC',
                'TU9',
                'ER9',
            ]),
            'reg_number' => $this->faker->numberBetween(1111, 9999),
            'status' => $this->faker->randomElement([
                'works',
                'broken',
            ]),
        ];
    }
}
