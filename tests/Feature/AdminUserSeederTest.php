<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_seeder_creates_an_active_admin_with_a_hashed_password(): void
    {
        $this->seed(AdminUserSeeder::class);

        $admin = User::query()
            ->where('email', 'admin@pkbmalfalah.test')
            ->firstOrFail();

        $this->assertSame(UserRole::ADMIN, $admin->role);
        $this->assertTrue($admin->is_active);
        $this->assertTrue(Hash::check('password', $admin->password));
        $this->assertNotSame('password', $admin->password);
    }
}
