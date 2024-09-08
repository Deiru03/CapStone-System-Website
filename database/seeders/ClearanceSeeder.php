<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Clearance;

class ClearanceSeeder extends Seeder
{
     /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Clearance::create([
                'user_id' => $user->id,
                'status' => 'Pending',
                'checked_by' => 'Admin 001',
            ]);
        }
    }
}
