<?php

namespace Database\Seeders;

use App\Models\DocumentationEvent;
use App\Models\DocumentationMedia;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Kegiatan Belajar Outdoor',
                'slug' => 'kegiatan-belajar-outdoor',
                'event_date' => '2026-07-01',
                'location' => 'Taman Kota Bekasi',
                'description' => 'Kegiatan pembelajaran di luar kelas untuk mengenalkan peserta didik pada lingkungan alam sekitar. Siswa diajak mengamati tumbuhan, satwa, dan ekosistem taman kota.',
                'is_published' => true,
                'sort_order' => null,
            ],
            [
                'title' => 'Perayaan Hari Kemerdekaan',
                'slug' => 'perayaan-hari-kemerdekaan',
                'event_date' => '2026-06-17',
                'location' => 'Halaman PKBM Al Falah',
                'description' => 'Upacara bendera dan lomba-lomba memperingati Hari Kemerdekaan Republik Indonesia. Seluruh peserta didik dari berbagai jenjang mengikuti kegiatan dengan penuh semangat.',
                'is_published' => true,
                'sort_order' => null,
            ],
            [
                'title' => 'Workshop Guru dan Tenaga Pendidik',
                'slug' => 'workshop-guru-dan-tenaga-pendidik',
                'event_date' => '2026-06-05',
                'location' => 'Ruang Aula PKBM',
                'description' => 'Kegiatan pelatihan dan pengembangan kompetensi guru dalam metode pembelajaran modern dan pendekatan student-centered learning.',
                'is_published' => true,
                'sort_order' => null,
            ],
            [
                'title' => 'Kegiatan Kunjungan Perpustakaan',
                'slug' => 'kegiatan-kunjungan-perpustakaan',
                'event_date' => '2026-05-20',
                'location' => 'Perpustakaan Daerah Bekasi',
                'description' => 'Kunjungan edukatif ke perpustakaan untuk menumbuhkan minat baca dan literasi peserta didik jenjang SD dan SMP.',
                'is_published' => true,
                'sort_order' => null,
            ],
            [
                'title' => 'Kegiatan Tahfidz dan Kajian Rutin',
                'slug' => 'kegiatan-tahfidz-dan-kajian-rutin',
                'event_date' => '2026-05-10',
                'location' => 'Mushola PKBM Al Falah',
                'description' => 'Kegiatan tahfidz dan kajian keagamaan rutin yang diikuti peserta didik jenjang PAUD hingga SMA sebagai bagian dari program pembinaan karakter.',
                'is_published' => true,
                'sort_order' => null,
            ],
        ];

        foreach ($events as $eventData) {
            $event = DocumentationEvent::create($eventData);

            $mediaCount = rand(2, 4);
            for ($i = 1; $i <= $mediaCount; $i++) {
                DocumentationMedia::create([
                    'documentation_event_id' => $event->id,
                    'type' => 'photo',
                    'path' => null,
                    'embed_url' => null,
                    'thumbnail_path' => null,
                    'caption' => 'Dokumentasi '.strtolower($event->title).' - foto '.$i,
                    'sort_order' => $i,
                    'is_featured' => $i === 1,
                ]);
            }
        }
    }
}
