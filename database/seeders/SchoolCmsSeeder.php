<?php

namespace Database\Seeders;

use App\Models\ContentSection;
use App\Models\Program;
use App\Models\SchoolProfile;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Database\Seeder;

class SchoolCmsSeeder extends Seeder
{
    public function run(): void
    {
        SchoolProfile::create([
            'school_name' => 'PKBM Al Falah Sumur Batu',
            'tagline' => 'Pendidikan Terpadu untuk Masa Depan yang Lebih Baik',
            'address' => 'Sumur Batu, Bantargebang, Kota Bekasi, Jawa Barat',
            'phone' => '081234567890',
            'email' => 'info@alfalahsumurbatu.sch.id',
            'description' => 'PKBM Al Falah Sumur Batu adalah lembaga pendidikan yang berkomitmen menyediakan lingkungan belajar yang ramah, terarah, dan mendukung perkembangan peserta didik dari berbagai jenjang pendidikan.',
            'maps_embed' => null,
        ]);

        $this->seedContentSections();
        $programs = $this->seedPrograms();
        $subjects = $this->seedSubjects();
        $teachers = $this->seedTeachers();
        $this->seedTeacherAssignments($teachers, $subjects, $programs);
    }

    private function seedContentSections(): void
    {
        ContentSection::insert([
            [
                'section_key' => 'profil',
                'title' => 'Profil Sekolah',
                'subtitle' => 'Lingkungan belajar yang ramah dan terarah',
                'content' => 'PKBM Al Falah Sumur Batu hadir sebagai lembaga pendidikan yang mendampingi peserta didik dalam mengembangkan pengetahuan, karakter, dan keterampilan sesuai tahap perkembangannya.',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section_key' => 'visi',
                'title' => 'Visi',
                'subtitle' => null,
                'content' => 'Menjadi lembaga pendidikan yang membentuk peserta didik berkarakter baik, berpengetahuan, mandiri, dan siap berkembang di tengah masyarakat.',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section_key' => 'misi',
                'title' => 'Misi',
                'subtitle' => null,
                'content' => "Menyelenggarakan pembelajaran yang terarah dan sesuai kebutuhan peserta didik.\nMendukung pembentukan karakter, kedisiplinan, dan kepedulian sosial.\nMenciptakan lingkungan belajar yang aman, ramah, dan kolaboratif.\nMengembangkan potensi akademik dan nonakademik secara seimbang.",
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section_key' => 'sejarah',
                'title' => 'Sejarah Singkat',
                'subtitle' => 'Perjalanan pelayanan pendidikan',
                'content' => 'PKBM Al Falah Sumur Batu berkembang dari kepedulian terhadap kebutuhan pendidikan masyarakat sekitar. Lembaga ini terus menata layanan pembelajaran dan program pendidikan agar dapat memberikan pendampingan yang relevan bagi peserta didik dan keluarga.',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * @return array<string, Program>
     */
    private function seedPrograms(): array
    {
        $programData = [
            ['name' => 'PAUD', 'slug' => 'paud', 'description' => 'Program pendidikan usia dini yang mendukung pertumbuhan, kemandirian, dan kesiapan belajar anak.'],
            ['name' => 'TK', 'slug' => 'tk', 'description' => 'Program taman kanak-kanak dengan kegiatan belajar yang aktif, menyenangkan, dan sesuai tahap perkembangan anak.'],
            ['name' => 'SD', 'slug' => 'sd', 'description' => 'Program pendidikan dasar untuk membangun kemampuan literasi, numerasi, karakter, dan pengetahuan umum.'],
            ['name' => 'SMP', 'slug' => 'smp', 'description' => 'Program pendidikan menengah pertama yang memperkuat dasar akademik, keterampilan, dan tanggung jawab peserta didik.'],
            ['name' => 'SMA', 'slug' => 'sma', 'description' => 'Program pendidikan menengah atas yang mempersiapkan peserta didik untuk melanjutkan pendidikan dan mengembangkan potensi diri.'],
        ];

        $programs = [];

        foreach ($programData as $index => $data) {
            $programs[$data['slug']] = Program::create([
                ...$data,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        return $programs;
    }

    /**
     * @return array<string, Subject>
     */
    private function seedSubjects(): array
    {
        $subjectNames = [
            'Pendidikan Agama Islam',
            'Bahasa Indonesia',
            'Matematika',
            'IPA',
            'IPS',
            'Bahasa Inggris',
            'Tahfidz',
            'Seni Budaya',
        ];

        $subjects = [];

        foreach ($subjectNames as $name) {
            $subjects[$name] = Subject::create(['name' => $name]);
        }

        return $subjects;
    }

    /**
     * @return array<string, Teacher>
     */
    private function seedTeachers(): array
    {
        $teacherData = [
            [
                'name' => 'Ahmad Fauzi',
                'slug' => 'ahmad-fauzi',
                'position' => 'Guru Matematika',
                'education' => 'S1 Pendidikan Matematika',
                'bio' => 'Mendampingi peserta didik memahami konsep matematika melalui latihan yang terarah dan contoh yang dekat dengan kehidupan sehari-hari.',
                'email' => 'ahmad.fauzi@example.com',
                'phone' => '081200000001',
            ],
            [
                'name' => 'Siti Rahmawati',
                'slug' => 'siti-rahmawati',
                'position' => 'Guru Bahasa Inggris',
                'education' => 'S1 Pendidikan Bahasa Inggris',
                'bio' => 'Mendorong peserta didik membangun keberanian berkomunikasi dalam Bahasa Inggris melalui kegiatan belajar yang bertahap.',
                'email' => 'siti.rahmawati@example.com',
                'phone' => '081200000002',
            ],
            [
                'name' => 'Nur Aisyah',
                'slug' => 'nur-aisyah',
                'position' => 'Guru Tahfidz',
                'education' => 'S1 Pendidikan Agama Islam',
                'bio' => 'Mendampingi pembelajaran tahfidz dengan pendekatan yang sabar, rutin, dan disesuaikan dengan kemampuan peserta didik.',
                'email' => 'nur.aisyah@example.com',
                'phone' => '081200000003',
            ],
            [
                'name' => 'Muhammad Rizki',
                'slug' => 'muhammad-rizki',
                'position' => 'Guru Pendidikan Agama Islam',
                'education' => 'S1 Pendidikan Agama Islam',
                'bio' => 'Mengajar Pendidikan Agama Islam dengan penekanan pada pemahaman dasar, pembiasaan baik, dan penerapan dalam keseharian.',
                'email' => 'muhammad.rizki@example.com',
                'phone' => '081200000004',
            ],
            [
                'name' => 'Dewi Lestari',
                'slug' => 'dewi-lestari',
                'position' => 'Guru Bahasa Indonesia',
                'education' => 'S1 Pendidikan Bahasa dan Sastra Indonesia',
                'bio' => 'Membimbing peserta didik meningkatkan kemampuan membaca, menulis, menyimak, dan menyampaikan gagasan secara jelas.',
                'email' => 'dewi.lestari@example.com',
                'phone' => '081200000005',
            ],
            [
                'name' => 'Budi Santoso',
                'slug' => 'budi-santoso',
                'position' => 'Guru IPA dan IPS',
                'education' => 'S1 Pendidikan Ilmu Pengetahuan Alam',
                'bio' => 'Mengajak peserta didik memahami lingkungan alam dan sosial melalui pengamatan, diskusi, dan pembelajaran kontekstual.',
                'email' => 'budi.santoso@example.com',
                'phone' => '081200000006',
            ],
        ];

        $teachers = [];

        foreach ($teacherData as $data) {
            $teachers[$data['slug']] = Teacher::create([
                ...$data,
                'is_active' => true,
            ]);
        }

        return $teachers;
    }

    /**
     * @param  array<string, Teacher>  $teachers
     * @param  array<string, Subject>  $subjects
     * @param  array<string, Program>  $programs
     */
    private function seedTeacherAssignments(
        array $teachers,
        array $subjects,
        array $programs
    ): void {
        $assignments = [
            ['ahmad-fauzi', 'Matematika', 'sd'],
            ['ahmad-fauzi', 'Matematika', 'smp'],
            ['siti-rahmawati', 'Bahasa Inggris', 'smp'],
            ['siti-rahmawati', 'Bahasa Inggris', 'sma'],
            ['nur-aisyah', 'Tahfidz', 'paud'],
            ['nur-aisyah', 'Tahfidz', 'tk'],
            ['nur-aisyah', 'Tahfidz', 'sd'],
            ['muhammad-rizki', 'Pendidikan Agama Islam', 'sd'],
            ['muhammad-rizki', 'Pendidikan Agama Islam', 'smp'],
            ['muhammad-rizki', 'Pendidikan Agama Islam', 'sma'],
            ['dewi-lestari', 'Bahasa Indonesia', 'sd'],
            ['dewi-lestari', 'Bahasa Indonesia', 'smp'],
            ['dewi-lestari', 'Seni Budaya', 'tk'],
            ['budi-santoso', 'IPA', 'smp'],
            ['budi-santoso', 'IPA', 'sma'],
            ['budi-santoso', 'IPS', 'smp'],
        ];

        foreach ($assignments as [$teacherSlug, $subjectName, $programSlug]) {
            TeacherAssignment::create([
                'teacher_id' => $teachers[$teacherSlug]->id,
                'subject_id' => $subjects[$subjectName]->id,
                'program_id' => $programs[$programSlug]->id,
            ]);
        }
    }
}
