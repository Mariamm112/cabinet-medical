<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create users (optional)
        User::factory(10)->create();

        // Call other seeders
        $this->call([
            RoleSeeder::class,
        ]);
    }
}