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
            'address' => 'Admin St',
            'phone' => '09123123123',
            'dob' => '1997-02-16',
            'credential_id' => 1,
            'image' => null,
            'last_login' => null,
            'status' => 'Active'
        ]);
    }
}
