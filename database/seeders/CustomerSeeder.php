<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Customer One',
            'address' => 'Customer St',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'credential_id' => 4,
            'last_login' => null,
            'image' => null,
            'status' => 'active'
        ]);

        Customer::create([
            'name' => 'Customer Two',
            'address' => 'Customer St',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'credential_id' => 5,
            'last_login' => null,
            'image' => null,
            'status' => 'active'
        ]);

        Customer::create([
            'name' => 'Customer Three',
            'address' => 'Customer St',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'credential_id' => 6,
            'last_login' => null,
            'image' => null,
            'status' => 'active'
        ]);

        Customer::create([
            'name' => 'Customer Four',
            'address' => 'Customer St',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'credential_id' => 7,
            'last_login' => null,
            'image' => null,
            'status' => 'active'
        ]);

        Customer::create([
            'name' => 'Customer Five',
            'address' => 'Customer St',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'credential_id' => 8,
            'last_login' => null,
            'image' => null,
            'status' => 'active'
        ]);

        Customer::create([
            'name' => 'Customer Six',
            'address' => 'Customer St',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'credential_id' => 9,
            'last_login' => null,
            'image' => null,
            'status' => 'active'
        ]);
    }
}
