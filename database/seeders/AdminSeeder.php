<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '01234567890',
            'address' => 'Admin Address',
            'role' => 1,
            'image' => 'default.jpg',
            'password' => bcrypt('password'), // Use a secure password here
        ]);
    }
}
