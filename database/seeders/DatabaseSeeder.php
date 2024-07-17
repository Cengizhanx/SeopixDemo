<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Emre Yıldırım',
            'email' => 'emre@seopix.net',
            'role' => 'admin',
            'phone' => '0535 737 90 16',
            'position' => 'CEO',
            'password' => '123456789'
        ]);
        User::factory()->create([
            'name' => 'Eren Hüner',
            'email' => 'eren@seopix.net',
            'role' => 'personal',
            'phone' => '0535 123 90 16',
            'position' => 'intern',
            'password' => bcrypt('123456789'),
        ]);
    }
}
