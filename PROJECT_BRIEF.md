# Project Brief — Sekolah CMS

## Ringkasan Project

- **Jenis project:** Website profil sekolah berbasis CMS sederhana.
- **Nama lembaga:** PKBM Al Falah Sumur Batu.
- **Karakter project:** Website profil sekolah / semi company profile, bukan sistem akademik penuh.
- **Tujuan:** Menyajikan informasi lembaga, program pendidikan, guru, dan kontak secara profesional, formal, ramah, serta mudah dipahami.

Requirement project masih bersifat sementara dan dapat berubah setelah memperoleh feedback resmi dari pihak sekolah. Struktur data dan kode karena itu harus tetap sederhana, fleksibel, mudah dikembangkan, dan mudah dijelaskan saat presentasi.

## Scope Public Website

Public website akan dibuat dalam bentuk single-page dengan bagian:

1. Beranda / hero.
2. Profil sekolah.
3. Visi dan misi.
4. Program pendidikan.
5. Sejarah singkat.
6. Guru dan tenaga pendidik.
7. Kontak.
8. Footer.

Detail guru tetap menggunakan halaman tersendiri agar informasi mata pelajaran dan jenjang yang diajar dapat ditampilkan dengan jelas.

## Program Pendidikan

Program pendidikan awal yang digunakan:

- PAUD
- TK
- SD
- SMP
- SMA

Konsep Paket A, Paket B, dan Paket C belum digunakan sampai ada feedback resmi dari pihak sekolah.

## Scope Admin CMS

Admin CMS akan dikerjakan setelah public website stabil. Scope admin nantinya meliputi:

- Autentikasi admin.
- Dashboard.
- Pengelolaan profil sekolah.
- Pengelolaan konten profil, visi, misi, dan sejarah.
- Pengelolaan program pendidikan.
- Pengelolaan guru.
- Pengelolaan mata pelajaran.
- Pengelolaan relasi guru, mata pelajaran, dan program.
- Upload logo, banner, foto guru, dan gambar konten.

## Fitur yang Belum Dibuat

Tahap awal tidak mencakup:

- Login dan portal guru.
- Data siswa.
- Absensi.
- Nilai.
- Jadwal pelajaran kompleks.
- Export PDF atau Excel.
- Berita dan galeri lengkap.
- Pendaftaran online.
- Donasi online.
- Payment gateway.

## Urutan Pengembangan

1. Menyelesaikan foundation project dan database.
2. Membangun public website single-page.
3. Menguji dan menstabilkan public website.
4. Membangun autentikasi dan admin CMS.
5. Menyelesaikan validasi, upload gambar, dan pengujian akhir.

Data utama tidak boleh di-hardcode pada view. Data harus berasal dari database agar perubahan requirement dapat dilakukan tanpa mengubah struktur tampilan secara berlebihan.
