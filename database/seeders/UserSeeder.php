<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'full_name' => 'Admin',
            'email' => 'admin@site.com',
            'role' => 'admin',
        ]);
    }
}
