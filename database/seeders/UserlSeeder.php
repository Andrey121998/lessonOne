<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserlSeeder extends Seeder
{
    public function run()
    {
        DB::table('usersl')->insert([
            ['name' => 'Иван Иванов', 'email' => 'ivan@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Петр Петров', 'email' => 'petr@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Анна Сидорова', 'email' => 'anna@example.com', 'password' => Hash::make('password'), 'role' => 'admin'],
            ['name' => 'Мария Козлова', 'email' => 'maria@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Сергей Смирнов', 'email' => 'sergey@example.com', 'password' => Hash::make('password'), 'role' => 'user'],
        ]);
    }
}