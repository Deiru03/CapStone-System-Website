<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearancesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('clearances')->insert([
            ['user_id' => 1, 'status' => 'Approved', 'checked_by' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'status' => 'Pending', 'checked_by' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            // Add more records as needed
        ]);
    }
}