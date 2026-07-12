@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-dashboard-header">
        <div>
            <span class="admin-kicker">Dashboard Admin</span>
            <h1 class="admin-title">Ringkasan CMS Sekolah</h1>
            <p class="admin-subtitle">Kelola konten website dan data guru PKBM Al Falah.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.teachers.create') }}">Tambah Guru</a>
    </div>

    <section class="admin-stat-grid" aria-label="Statistik utama">
        <article class="admin-stat-card">
            <span>Total Guru</span>
            <strong>{{ $totalTeachers }}</strong>
        </article>
        <article class="admin-stat-card">
            <span>Total Akun Guru</span>
            <strong>{{ $totalTeacherAccounts }}</strong>
        </article>
        <article class="admin-stat-card">
            <span>Belum Memiliki Akun</span>
            <strong>{{ $teachersWithoutAccounts }}</strong>
        </article>
        <article class="admin-stat-card">
            <span>Total Program</span>
            <strong>{{ $totalPrograms }}</strong>
        </article>
    </section>

    <section class="admin-section">
        <div class="admin-section-header">
            <h2 class="admin-section-title">Data Guru Terbaru</h2>
            <a class="admin-link" href="{{ route('admin.teachers.index') }}">Lihat Semua</a>
        </div>

        <div class="admin-card admin-table-card">
            @if ($latestTeachers->isNotEmpty())
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Status Akun</th>
                                <th>Assignment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestTeachers as $teacher)
                                <tr>
                                    <td><a href="{{ route('admin.teachers.show', $teacher) }}">{{ $teacher->name }}</a></td>
                                    <td>{{ $teacher->position ?: 'Belum tersedia' }}</td>
                                    <td>
                                        @if ($teacher->user)
                                            <span class="admin-badge">Memiliki Akun</span>
                                        @else
                                            <span class="admin-badge admin-badge-warning">Belum Memiliki Akun</span>
                                        @endif
                                    </td>
                                    <td>{{ $teacher->teacherAssignments->count() }} assignment</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="admin-empty">
                    <p>Belum ada data guru.</p>
                    <a class="admin-btn" href="{{ route('admin.teachers.create') }}">Tambah Guru</a>
                </div>
            @endif
        </div>
    </section>
@endsection
