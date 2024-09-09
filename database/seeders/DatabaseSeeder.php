<?php

namespace Database\Seeders;

use App\Models\Clearance;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            //UserSeeder::class, // Ensure this is called first
            ClearanceSeeder::class, // Call your clearance seeder
        ]);
    }
}
