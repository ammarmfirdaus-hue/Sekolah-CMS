<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\SchoolCmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard(): void
    {
        $this->seed(SchoolCmsSeeder::class);
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.index'))
            ->assertOk()
            ->assertSee('Ringkasan CMS Sekolah')
            ->assertSee('Total Guru')
            ->assertSee('Total Program');
    }

    public function test_teacher_cannot_access_dashboard(): void
    {
        $teacher = User::factory()->create();

        $this->actingAs($teacher)
            ->get(route('admin.index'))
            ->assertForbidden();
    }
}
