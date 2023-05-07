<?php

namespace Database\Seeders;

use App\Models\Delivery;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        Delivery::factory(10)->create([
            'driver_id' => null,
            'dispatcher_id' => null
        ]);

        Delivery::factory(15)->create();
    }
}
