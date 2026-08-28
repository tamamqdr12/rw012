<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin RW 012
        User::updateOrCreate(
            ['email' => 'admin@rw12.com'],
            [
                'name' => 'Admin RW 012',
                'password' => Hash::make('pak madroni'),
                'role' => 'admin_rw'
            ]
        );

        // 2. Admin RT 001
        User::updateOrCreate(
            ['email' => 'admin@rt01.com'],
            [
                'name' => 'Admin RT 001',
                'password' => Hash::make('pak agus'),
                'role' => 'admin_rt001'
            ]
        );

        // 3. Admin RT 002
        User::updateOrCreate(
            ['email' => 'admin@rw02.com'],
            [
                'name' => 'Admin RT 002',
                'password' => Hash::make('pak heri'),
                'role' => 'admin_rt002'
            ]
        );

        // 4. Admin RT 003
        User::updateOrCreate(
            ['email' => 'admin@rt03.com'],
            [
                'name' => 'Admin RT 003',
                'password' => Hash::make('pak nurdin'),
                'role' => 'admin_rt003'
            ]
        );

        // 5. Admin Karang Taruna
        User::updateOrCreate(
            ['email' => 'admin@karangtaruna.com'],
            [
                'name' => 'Admin Karang Taruna',
                'password' => Hash::make('mas haikal'),
                'role' => 'admin_karang_taruna'
            ]
        );
    }
}
