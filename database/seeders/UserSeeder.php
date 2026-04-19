<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔥 ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'no_hp' => '081234567890'
        ]);

        // 🔥 GURU
        User::create([
            'name' => 'Guru',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'guru',
            'no_hp' => '081234567891'
        ]);

        // 🔥 ORANG TUA
        User::create([
            'name' => 'Orang Tua',
            'email' => 'ortu@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'orang_tua',
            'no_hp' => '081234567892'
        ]);
    }
}
