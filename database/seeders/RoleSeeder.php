<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'status' => 'Active'
        ]);

        Role::create([
            'name' => 'Manager',
            'status' => 'Active'
        ]);

        Role::create([
            'name' => 'Staff',
            'status' => 'Active'
        ]);
    }
}
