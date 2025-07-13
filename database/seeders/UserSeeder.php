<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
        ]);

        // Visitor (Demo)
        User::updateOrCreate([
            'email' => 'visitor@example.com',
        ], [
            'name' => 'Visitor',
            'password' => Hash::make('password'),
            'role' => UserRole::Visitor,
        ]);
    }
}
