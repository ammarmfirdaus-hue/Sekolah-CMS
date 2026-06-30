<?php

namespace Tests\Feature;

use App\Models\Teacher;
use Database\Seeders\SchoolCmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_cms_seeder_creates_the_expected_foundation_data(): void
    {
        $this->seed(SchoolCmsSeeder::class);

        $this->assertDatabaseCount('school_profiles', 1);
        $this->assertDatabaseCount('content_sections', 4);
        $this->assertDatabaseCount('programs', 5);
        $this->assertDatabaseCount('subjects', 8);
        $this->assertDatabaseCount('teachers', 6);
        $this->assertDatabaseCount('teacher_assignments', 16);

        $this->assertDatabaseHas('school_profiles', [
            'school_name' => 'PKBM Al Falah Sumur Batu',
        ]);
    }

    public function test_teacher_assignments_load_their_subject_and_program(): void
    {
        $this->seed(SchoolCmsSeeder::class);

        $teacher = Teacher::query()
            ->with(['teacherAssignments.subject', 'teacherAssignments.program'])
            ->where('slug', 'ahmad-fauzi')
            ->firstOrFail();

        $assignments = $teacher->teacherAssignments
            ->map(fn ($assignment) => "{$assignment->subject->name}:{$assignment->program->slug}")
            ->all();

        $this->assertEqualsCanonicalizing([
            'Matematika:sd',
            'Matematika:smp',
        ], $assignments);
    }
}
