<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'driver_id' => User::factory()->driver(),
            'dispatcher_id' => User::factory()->dispatcher(),
            'sender' => $this->faker->company,
            'receiver' => $this->faker->company,
            'loading_location' => $this->faker->country,
            'destination' => $this->faker->country,
            'arrival_time' => $this->faker->dateTime,
            'cargo' => [
                'name' => 'Генератори',
                'quantity' => 2,
                'weight' => 1000,
                'size' => '1000x1000'
            ],
            'status' => $this->faker->randomElement([
                'scheduled',
                'in_progress',
                'waits_to_load',
                'awaiting_unloading',
                'shipped',
                'finished'
            ])
        ];
    }
}
