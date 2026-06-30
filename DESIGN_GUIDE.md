# Design Guide — Sekolah CMS

## Arah Visual

Tampilan sementara menggunakan karakter visual yang edukatif, formal, ramah, sederhana, dan terpercaya. Desain harus terasa bersih dan mudah dibaca tanpa terlihat terlalu ramai atau terlalu kaku seperti website korporat.

## Palet Warna

- Hijau sebagai warna utama.
- Hijau gelap sebagai warna penegas.
- Kuning sebagai aksen.
- Putih dan cream sebagai background.
- Abu gelap sebagai warna teks.

Seluruh warna tema global disimpan di `public/css/theme.css`:

```css
:root {
  --color-primary: #2E7D32;
  --color-primary-dark: #1B5E20;
  --color-accent: #F2C94C;
  --color-accent-soft: #FFF6D8;
  --color-bg: #FAFAF5;
  --color-surface: #FFFFFF;
  --color-text: #1F2937;
  --color-muted: #6B7280;
  --color-border: #E5E7EB;
}
```

Warna tema tidak boleh di-hardcode berulang kali pada view atau komponen. Jika membutuhkan variasi warna baru yang digunakan lebih dari sekali, tambahkan CSS variable yang memiliki nama semantik.

## Aturan Desain

- Gunakan tipografi yang jelas dan ukuran teks yang nyaman dibaca.
- Gunakan card putih dengan shadow halus.
- Gunakan border radius yang lembut dan konsisten.
- Jaga whitespace agar konten tidak terasa padat.
- Pastikan kontras teks dan background memadai.
- Buat layout responsive untuk mobile, tablet, dan desktop.
- Navbar public nantinya dibuat sticky.
- Gunakan Bootstrap untuk grid dan komponen dasar.
- Gunakan custom CSS secukupnya untuk identitas visual.

## Arah Public Website

Public website menggunakan layout single-page dengan urutan section yang jelas. Hero menjadi pengantar utama, kemudian informasi profil, visi dan misi, program, sejarah, guru, serta kontak. Navigasi menggunakan anchor menuju setiap section. Halaman detail guru tetap berdiri sendiri.

Konten harus mudah dipindai, menggunakan judul section yang konsisten, dan tidak bergantung pada paragraf yang terlalu panjang.

## Arah Admin CMS

Admin nantinya menggunakan layout yang lebih fungsional:

- Navigasi konsisten dan mudah dipahami.
- Form sederhana dengan label dan validasi yang jelas.
- Tabel data responsive.
- Tombol aksi memiliki hierarki visual yang konsisten.
- Warna tetap mengikuti theme global agar public dan admin terasa sebagai satu sistem.

Admin tidak perlu memiliki dekorasi sebanyak public website; prioritasnya adalah kejelasan dan efisiensi pengelolaan data.
