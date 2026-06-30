<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_area_but_not_teacher_area(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.index'))
            ->assertOk()
            ->assertSee('Ringkasan CMS Sekolah');

        $this->actingAs($admin)
            ->get(route('teacher-portal.index'))
            ->assertForbidden();
    }

    public function test_teacher_can_access_teacher_area_but_not_admin_area(): void
    {
        $teacher = User::factory()->create();

        $this->actingAs($teacher)
            ->get(route('teacher-portal.index'))
            ->assertOk()
            ->assertSee('Portal Guru');

        $this->actingAs($teacher)
            ->get(route('admin.index'))
            ->assertForbidden();
    }

    public function test_guest_is_redirected_from_private_areas_to_login(): void
    {
        $this->get(route('admin.index'))
            ->assertRedirect(route('login'));

        $this->get(route('teacher-portal.index'))
            ->assertRedirect(route('login'));
    }
}
