<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create([
            'role_id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'One',
            'address' => fake()->address(),
            'phone' => '09' . fake()->numberBetween(400000000, 999999999),
            'dob' => '1997-02-16',
            'credential_id' => 1,
            'image' => null,
            'last_login' => null,
            'status' => 'active' 
        ]);

        Staff::create([
            'role_id' => 2,
            'first_name' => 'Manager',
            'last_name' => 'One',
            'address' => fake()->address(),
            'phone' => '09' . fake()->numberBetween(400000000, 999999999),
            'dob' => '1997-02-16',
            'credential_id' => 2,
            'image' => null,
            'last_login' => null,
            'status' => 'active' 
        ]);

        Staff::create([
            'role_id' => 3,
            'first_name' => 'Staff',
            'last_name' => 'One',
            'address' => fake()->address(),
            'phone' => '09' . fake()->numberBetween(400000000, 999999999),
            'dob' => '1997-02-16',
            'credential_id' => 3,
            'image' => null,
            'last_login' => null,
            'status' => 'active' 
        ]);
    }
}
