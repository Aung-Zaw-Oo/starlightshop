<?php

namespace Database\Seeders;

use App\Models\Credential;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $credentials = [
            ['email' => 'adminone@example.com', 'password' => 'password'],
            ['email' => 'managerone@example.com', 'password' => 'password'],
            ['email' => 'staffone@example.com', 'password' => 'password'],
            ['email' => 'cus.one@example.com', 'password' => 'password'],
            ['email' => 'cus.two@example.com', 'password' => 'password'],
            ['email' => 'cus.three@example.com', 'password' => 'password'],
            ['email' => 'cus.four@example.com', 'password' => 'password'],
            ['email' => 'cus.five@example.com', 'password' => 'password'],
            ['email' => 'cus.six@example.com', 'password' => 'password'],
        ];

        foreach ($credentials as $credential) {
            Credential::create([
                'email' => $credential['email'],
                'password' => Hash::make($credential['password']),
            ]);
        }
    }
}
