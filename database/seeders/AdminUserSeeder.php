<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@pkbmalfalah.test'],
            [
                'name' => 'Administrator PKBM Al Falah',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'is_active' => true,
                'must_change_password' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}
