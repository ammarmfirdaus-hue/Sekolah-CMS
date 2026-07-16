@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Dashboard Admin</span>
            <h1 class="admin-title">Ringkasan CMS Sekolah</h1>
            <p class="admin-subtitle">Kelola konten website dan data guru PKBM Al Falah.</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <section class="admin-stat-grid" aria-label="Statistik utama">
        <article class="admin-stat-card">
            <span class="admin-stat-label">Total Guru</span>
            <strong class="admin-stat-value">{{ $totalTeachers }}</strong>
        </article>
        <article class="admin-stat-card">
            <span class="admin-stat-label">Total Akun Guru</span>
            <strong class="admin-stat-value">{{ $totalTeacherAccounts }}</strong>
        </article>
        <article class="admin-stat-card">
            <span class="admin-stat-label">Total Program</span>
            <strong class="admin-stat-value">{{ $totalPrograms }}</strong>
        </article>
        <article class="admin-stat-card">
            <span class="admin-stat-label">Belum Memiliki Akun</span>
            <strong class="admin-stat-value">{{ $teachersWithoutAccounts }}</strong>
            @if($teachersWithoutAccounts > 0)
                <div class="admin-stat-note">
                    <span class="admin-badge-warning">Perlu ditindaklanjuti</span>
                </div>
            @endif
        </article>
    </section>

    {{-- Latest Teachers --}}
    <section class="admin-section">
        <div class="admin-section-header">
            <h2 class="admin-section-title">Data Guru Terbaru</h2>
            <a class="admin-link" href="{{ route('admin.teachers.index') }}">Lihat Semua</a>
        </div>

        <div class="admin-table-card">
            @if($latestTeachers->isNotEmpty())
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
                            @foreach($latestTeachers as $teacher)
                                @php
                                    $initials = collect(explode(' ', $teacher->name))->filter()->take(2)->map(fn($p) => mb_strtoupper(mb_substr($p,0,1)))->implode('');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="admin-table-avatar-cell">
                                            @if($teacher->photo)
                                                <img class="admin-avatar" src="{{ asset('storage/'.ltrim($teacher->photo,'/')) }}" alt="Foto {{ $teacher->name }}">
                                            @else
                                                <span class="admin-avatar-placeholder">{{ $initials ?: 'GR' }}</span>
                                            @endif
                                            <a href="{{ route('admin.teachers.show', $teacher) }}">{{ $teacher->name }}</a>
                                        </div>
                                    </td>
                                    <td>{{ $teacher->position ?: '—' }}</td>
                                    <td>
                                        @if($teacher->user)
                                            <span class="admin-badge">Memiliki Akun</span>
                                        @else
                                            <span class="admin-badge-warning">Belum Memiliki Akun</span>
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
                    <p>Belum ada data guru. Mulai dengan menambahkan guru pertama.</p>
                    <a class="admin-btn" href="{{ route('admin.teachers.create') }}">Tambah Guru</a>
                </div>
            @endif
        </div>
    </section>
@endsection
