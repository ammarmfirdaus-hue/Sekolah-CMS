# PKBM Al Falah Information System

## Architecture Guideline

## Project Overview

Project ini merupakan sistem informasi PKBM Al Falah yang dikembangkan secara bertahap.

Semester ini fokus pada pembangunan **CMS Website Profil Sekolah**.

Semester berikutnya sistem akan berkembang menjadi **Sistem Informasi Sekolah** (Portal Guru, Akademik, Inventaris, dll).

---

# Development Principles

- Bangun fitur secara bertahap.
- Selesaikan satu modul sampai benar-benar selesai sebelum memulai modul berikutnya.
- Hindari perubahan besar yang tidak diperlukan.
- Selalu lakukan Planning → Review → Implementasi.
- Jangan melakukan refactor besar tanpa persetujuan.

---

# CMS Philosophy

Website publik hanya membaca data dari database.

Seluruh konten website harus dapat dikelola melalui Dashboard Admin.

Hindari hardcode pada Blade apabila data tersebut dapat berasal dari database.

---

# Architecture Decisions

## School Profile

SchoolProfile menggunakan singleton pattern.

Seluruh identitas sekolah berasal dari:

SchoolProfile::first()

meliputi:

- Logo
- Banner
- Foundation Name
- School Name
- Tagline
- Description
- Address
- Phone
- Email
- Maps

---

## Controller

Untuk project saat ini:

- Gunakan controller yang sudah ada.
- Jangan menambahkan View Composer atau Service Provider kecuali memang diperlukan.
- Hindari membuat arsitektur yang terlalu kompleks.

---

## Sidebar

Sidebar dikembangkan berdasarkan **modul**, bukan daftar halaman.

Contoh:

Dashboard

Website
Informasi Umum
Hero
Profil
Visi & Misi
Program
Sejarah
Pendaftaran
Dokumentasi
Struktur Organisasi

Guru

Pengaturan

Semester berikutnya modul baru dapat ditambahkan tanpa mengubah struktur sidebar.

---

## Dashboard

Dashboard berfungsi sebagai ringkasan sistem.

Dashboard bukan tempat untuk menampilkan seluruh fitur.

Hindari widget yang belum memiliki data nyata.

---

## UI Principles

Pertahankan identitas visual project.

- Bootstrap 5.3
- Warna hijau sebagai primary color
- Layout admin tetap dipertahankan
- Fokus pada penyempurnaan UX, bukan redesign total.

---

# Coding Style

- Gunakan Form Request untuk validasi.
- Gunakan Resource Controller bila sesuai.
- Gunakan Laravel Convention.
- Gunakan CSS yang sudah ada sebelum membuat class baru.
- Hindari duplikasi kode.

---

# Workflow

Setiap task mengikuti alur berikut:

Planning

↓

Review

↓

Implementasi

↓

Testing

↓

Bug Fix

↓

Review
