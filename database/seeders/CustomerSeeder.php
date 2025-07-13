<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Credential;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            $name = fake()->name();
            $slug = Str::slug($name, '');
            $email = $slug . $i . '@example.com';

            $credential = Credential::create([
                'email' => $email,
                'password' => Hash::make('password'),
            ]);

            Customer::create([
                'name' => $name,
                'address' => fake()->address(),
                'phone' => '09' . fake()->numberBetween(400000000, 999999999),
                'dob' => fake()->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
                'credential_id' => $credential->id,
                'last_login' => null,
                'image' => null,
                'status' => 'active',
            ]);
        }
    }
}
