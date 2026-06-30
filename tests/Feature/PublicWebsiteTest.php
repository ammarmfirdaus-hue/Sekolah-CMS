<?php

namespace Tests\Feature;

use App\Models\Teacher;
use Database\Seeders\SchoolCmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_seeded_public_content(): void
    {
        $this->seed(SchoolCmsSeeder::class);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('PKBM Al Falah Sumur Batu')
            ->assertSee('Program Pendidikan')
            ->assertSee('Guru &amp; Tenaga Pendidik', false)
            ->assertSee('Ahmad Fauzi')
            ->assertSee('Lingkungan Belajar Ramah')
            ->assertSee('Awal Perjalanan')
            ->assertSee('>SMP<', false)
            ->assertDontSee('card-number')
            ->assertSee('id="beranda"', false)
            ->assertSee('id="kontak"', false);
    }

    public function test_homepage_is_safe_when_public_data_is_empty(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('PKBM Al Falah Sumur Batu')
            ->assertSee('Informasi program pendidikan belum tersedia.')
            ->assertSee('Google Maps belum ditambahkan.');
    }

    public function test_active_teacher_detail_can_be_opened_by_slug(): void
    {
        $this->seed(SchoolCmsSeeder::class);

        $teacher = Teacher::query()->where('slug', 'ahmad-fauzi')->firstOrFail();

        $this->get(route('teachers.show', $teacher->slug))
            ->assertOk()
            ->assertSee($teacher->name)
            ->assertSee('aria-label="Breadcrumb"', false)
            ->assertSee('Matematika')
            ->assertSee('SD')
            ->assertSee('SMP');
    }

    public function test_inactive_or_unknown_teacher_returns_not_found(): void
    {
        $this->seed(SchoolCmsSeeder::class);

        Teacher::query()
            ->where('slug', 'ahmad-fauzi')
            ->update(['is_active' => false]);

        $this->get(route('teachers.show', 'ahmad-fauzi'))->assertNotFound();
        $this->get(route('teachers.show', 'tidak-ada'))->assertNotFound();
    }
}
