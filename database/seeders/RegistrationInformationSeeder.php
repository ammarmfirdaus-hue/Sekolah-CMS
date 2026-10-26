<?php

namespace Database\Seeders;

use App\Models\RegistrationInformation;
use Illuminate\Database\Seeder;

class RegistrationInformationSeeder extends Seeder
{
    public function run(): void
    {
        RegistrationInformation::query()->create([
            'title' => 'Pendaftaran Peserta Didik',
            'subtitle' => 'Informasi dan prosedur pendaftaran peserta didik baru.',
            'description' => 'Selamat datang di halaman pendaftaran. Silakan pelajari informasi pendaftaran berikut sebelum memulai proses pendaftaran.',
            'requirements' => "Dokumen persyaratan pendaftaran akan segera diisi oleh admin.\n\n- Pas foto 3x4\n- Fotokopi KK\n- Fotokopi Akta Kelahiran",
            'process' => "Alur pendaftaran akan segera diisi oleh admin.\n\n1. Isi formulir pendaftaran\n2. Verifikasi dokumen\n3. Pembayaran biaya pendaftaran\n4. Pengumuman hasil seleksi",
            'schedule' => "Jadwal pendaftaran akan segera diisi oleh admin.\n\nGelombang 1: -\nGelombang 2: -",
            'contact_info' => 'Hubungi bagian pendaftaran untuk informasi lebih lanjut.',
            'is_open' => true,
            'cta_text' => 'Hubungi Kami',
            'cta_url' => '#kontak',
        ]);
    }
}
