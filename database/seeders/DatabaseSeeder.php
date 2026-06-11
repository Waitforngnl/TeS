<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // USER
        User::factory()->create([
            'full_name' => 'Admin Shop',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'ADMIN',
        ]);
        User::factory()->create([
            'full_name' => 'Tester 1',
            'email' => 'tester1@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
