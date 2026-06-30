@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Dashboard Admin</span>
            <h1 class="admin-title">Ringkasan CMS Sekolah</h1>
            <p class="admin-subtitle">Pantau data guru, akun guru, dan program pendidikan PKBM Al Falah.</p>
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

    <section class="admin-card">
        <div class="admin-page-header">
            <div>
                <span class="admin-kicker">Data Terbaru</span>
                <h2 class="admin-title" style="font-size: 1.55rem;">Guru Terbaru</h2>
            </div>
            <a class="admin-btn-soft" href="{{ route('admin.teachers.index') }}">Lihat Semua</a>
        </div>

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
                    @forelse ($latestTeachers as $teacher)
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
                    @empty
                        <tr>
                            <td colspan="4">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
