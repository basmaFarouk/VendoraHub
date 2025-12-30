<?php

namespace Database\Seeders\Frontend;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@gmail.com',
            'password' => bcrypt('123456789'),
            'user_type' => 'vendor',
        ]);
    }
}
