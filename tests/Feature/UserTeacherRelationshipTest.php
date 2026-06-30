<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTeacherRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_and_teacher_have_a_one_to_one_relationship(): void
    {
        $user = User::factory()->create();
        $teacher = Teacher::query()->create([
            'user_id' => $user->id,
            'name' => 'Guru Pengujian',
            'slug' => 'guru-pengujian',
            'is_active' => true,
        ]);

        $this->assertTrue($user->teacher->is($teacher));
        $this->assertTrue($teacher->user->is($user));
    }

    public function test_deleting_user_does_not_delete_teacher_profile(): void
    {
        $user = User::factory()->create();
        $teacher = Teacher::query()->create([
            'user_id' => $user->id,
            'name' => 'Guru Tetap Tersimpan',
            'slug' => 'guru-tetap-tersimpan',
            'is_active' => true,
        ]);

        $user->delete();

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'user_id' => null,
        ]);
    }
}
