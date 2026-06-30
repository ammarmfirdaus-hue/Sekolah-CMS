<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use App\Models\User;
use Database\Seeders\SchoolCmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminTeacherManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SchoolCmsSeeder::class);
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_teacher_list_and_detail(): void
    {
        $teacher = Teacher::query()->where('slug', 'ahmad-fauzi')->firstOrFail();

        $this->actingAs($this->admin)
            ->get(route('admin.teachers.index'))
            ->assertOk()
            ->assertSee('Daftar Guru')
            ->assertSee($teacher->name);

        $this->actingAs($this->admin)
            ->get(route('admin.teachers.show', $teacher))
            ->assertOk()
            ->assertSee($teacher->name)
            ->assertSee('Informasi Akun')
            ->assertSee('Assignment Guru');
    }

    public function test_admin_can_search_teachers(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.teachers.index', ['search' => 'Ahmad']))
            ->assertOk()
            ->assertSee('Ahmad Fauzi')
            ->assertDontSee('Siti Rahmawati');
    }

    public function test_admin_can_create_teacher(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.teachers.store'), [
                'name' => 'Guru Baru',
                'slug' => 'guru-baru',
                'position' => 'Guru Kelas',
                'education' => 'S1 Pendidikan',
                'bio' => 'Bio guru baru.',
                'email' => 'guru.baru@example.com',
                'phone' => '081299999999',
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('teachers', [
            'name' => 'Guru Baru',
            'slug' => 'guru-baru',
        ]);
    }

    public function test_admin_can_update_teacher_and_slug_must_remain_unique(): void
    {
        $teacher = Teacher::query()->where('slug', 'ahmad-fauzi')->firstOrFail();
        $otherTeacher = Teacher::query()->where('slug', 'siti-rahmawati')->firstOrFail();

        $this->actingAs($this->admin)
            ->put(route('admin.teachers.update', $teacher), [
                'name' => 'Ahmad Fauzi Updated',
                'slug' => $teacher->slug,
                'position' => 'Koordinator Matematika',
                'education' => $teacher->education,
                'bio' => $teacher->bio,
                'email' => $teacher->email,
                'phone' => $teacher->phone,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.teachers.show', $teacher));

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'name' => 'Ahmad Fauzi Updated',
            'position' => 'Koordinator Matematika',
        ]);

        $this->actingAs($this->admin)
            ->from(route('admin.teachers.edit', $teacher))
            ->put(route('admin.teachers.update', $teacher), [
                'name' => 'Ahmad Fauzi Updated',
                'slug' => $otherTeacher->slug,
                'position' => 'Koordinator Matematika',
                'education' => $teacher->education,
                'bio' => $teacher->bio,
                'email' => $teacher->email,
                'phone' => $teacher->phone,
                'is_active' => true,
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_admin_can_delete_teacher_and_related_account(): void
    {
        $teacher = Teacher::query()->where('slug', 'ahmad-fauzi')->firstOrFail();
        $user = User::factory()->create(['role' => UserRole::TEACHER]);
        $teacher->update(['user_id' => $user->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.teachers.destroy', $teacher))
            ->assertRedirect(route('admin.teachers.index'));

        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_can_add_and_delete_assignment(): void
    {
        $teacher = Teacher::query()->where('slug', 'ahmad-fauzi')->firstOrFail();
        $program = Program::query()->where('slug', 'sma')->firstOrFail();
        $subject = Subject::query()->where('name', 'Matematika')->firstOrFail();

        $this->actingAs($this->admin)
            ->post(route('admin.teachers.assignments.store', $teacher), [
                'program_id' => $program->id,
                'subject_id' => $subject->id,
                'note' => 'Tambahan SMA',
            ])
            ->assertRedirect(route('admin.teachers.show', $teacher));

        $assignment = TeacherAssignment::query()
            ->where('teacher_id', $teacher->id)
            ->where('program_id', $program->id)
            ->where('subject_id', $subject->id)
            ->firstOrFail();

        $this->assertSame('Tambahan SMA', $assignment->note);

        $this->actingAs($this->admin)
            ->delete(route('admin.teachers.assignments.destroy', [$teacher, $assignment]))
            ->assertRedirect(route('admin.teachers.show', $teacher));

        $this->assertDatabaseMissing('teacher_assignments', ['id' => $assignment->id]);
    }

    public function test_duplicate_assignment_is_rejected(): void
    {
        $teacher = Teacher::query()->where('slug', 'ahmad-fauzi')->firstOrFail();
        $assignment = $teacher->teacherAssignments()->firstOrFail();

        $this->actingAs($this->admin)
            ->from(route('admin.teachers.assignments.create', $teacher))
            ->post(route('admin.teachers.assignments.store', $teacher), [
                'program_id' => $assignment->program_id,
                'subject_id' => $assignment->subject_id,
            ])
            ->assertSessionHasErrors('subject_id');
    }

    public function test_admin_can_create_teacher_account(): void
    {
        $teacher = Teacher::query()->whereNull('user_id')->firstOrFail();

        $this->actingAs($this->admin)
            ->post(route('admin.teachers.account.store', $teacher), [
                'email' => 'login.guru@example.com',
                'password' => 'temporary-password',
            ])
            ->assertRedirect(route('admin.teachers.show', $teacher))
            ->assertSessionHas('temporary_password', 'temporary-password');

        $teacher->refresh();

        $this->assertNotNull($teacher->user_id);
        $this->assertSame(UserRole::TEACHER, $teacher->user->role);
        $this->assertTrue($teacher->user->is_active);
        $this->assertTrue($teacher->user->must_change_password);
        $this->assertTrue(Hash::check('temporary-password', $teacher->user->password));
    }

    public function test_admin_can_deactivate_activate_and_reset_teacher_account(): void
    {
        $teacher = Teacher::query()->whereNull('user_id')->firstOrFail();
        $user = User::factory()->create(['role' => UserRole::TEACHER]);
        $teacher->update(['user_id' => $user->id]);

        $this->actingAs($this->admin)
            ->patch(route('admin.teachers.account.deactivate', $teacher))
            ->assertRedirect(route('admin.teachers.show', $teacher));

        $this->assertFalse($user->fresh()->is_active);

        $this->actingAs($this->admin)
            ->patch(route('admin.teachers.account.activate', $teacher))
            ->assertRedirect(route('admin.teachers.show', $teacher));

        $this->assertTrue($user->fresh()->is_active);

        $this->actingAs($this->admin)
            ->patch(route('admin.teachers.account.reset-password', $teacher))
            ->assertRedirect(route('admin.teachers.show', $teacher))
            ->assertSessionHas('temporary_password');

        $this->assertTrue($user->fresh()->must_change_password);
    }

    public function test_guest_and_teacher_are_denied_from_teacher_management(): void
    {
        $teacherUser = User::factory()->create(['role' => UserRole::TEACHER]);

        $this->get(route('admin.teachers.index'))
            ->assertRedirect(route('login'));

        $this->actingAs($teacherUser)
            ->get(route('admin.teachers.index'))
            ->assertForbidden();
    }
}
