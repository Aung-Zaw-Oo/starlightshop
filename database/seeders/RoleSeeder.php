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
            'status' => 'active'
        ]);

        Role::create([
            'name' => 'Manager',
            'status' => 'active'
        ]);

        Role::create([
            'name' => 'Staff',
            'status' => 'active'
        ]);
    }
}
