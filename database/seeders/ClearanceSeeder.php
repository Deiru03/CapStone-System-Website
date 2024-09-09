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
       // Fetch all users
    $users = User::all();

    // Loop through each user and create a clearance record
    foreach ($users as $user) {
        Clearance::create([
            'user_id' => $user->id, // Assuming you have a user_id field
            'status' => 'Pending',// Default status
            'checked_by' => 'Admin', // Provide a default value or set it to null if allowed
        ]);
    }
    }
}
