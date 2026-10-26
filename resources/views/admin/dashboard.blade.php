@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-dashboard-header">
        <div class="admin-dashboard-title-wrap">
            <span class="admin-kicker">DASHBOARD</span>
            <h1 class="admin-title">Ringkasan CMS Sekolah</h1>
            <p class="admin-subtitle">Kelola konten website dan data guru PKBM Al Falah dengan mudah dan terintegrasi.</p>
        </div>
        <div class="admin-dashboard-actions">
            <div class="admin-date-widget" aria-label="Tanggal hari ini">
                <i class="mdi mdi-calendar-month-outline admin-date-icon"></i>
                <div class="admin-date-meta">
                    <span class="admin-date-text">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                    <small class="admin-date-sub">Selamat datang di panel admin</small>
                </div>
            </div>
            <a class="admin-btn admin-btn-primary" href="{{ route('admin.teachers.create') }}">
                <i class="mdi mdi-plus"></i>
                <span>Tambah Guru</span>
            </a>
        </div>
    </div>

    <section class="admin-stat-grid" aria-label="Statistik utama">
        <article class="admin-stat-card">
            <div class="admin-stat-icon-wrap stat-icon-green">
                <i class="mdi mdi-account-group-outline"></i>
            </div>
            <div class="admin-stat-content">
                <span class="admin-stat-label">Total Guru</span>
                <strong class="admin-stat-value">{{ $totalTeachers }}</strong>
                <small class="admin-stat-desc">Seluruh guru dan tutor</small>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="admin-stat-icon-wrap stat-icon-blue">
                <i class="mdi mdi-account-outline"></i>
            </div>
            <div class="admin-stat-content">
                <span class="admin-stat-label">Total Akun Guru</span>
                <strong class="admin-stat-value">{{ $totalTeacherAccounts }}</strong>
                <small class="admin-stat-desc">Akun yang sudah dibuat</small>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="admin-stat-icon-wrap stat-icon-amber">
                <i class="mdi mdi-account-alert-outline"></i>
            </div>
            <div class="admin-stat-content">
                <span class="admin-stat-label">Belum Memiliki Akun</span>
                <strong class="admin-stat-value">{{ $teachersWithoutAccounts }}</strong>
                <small class="admin-stat-desc">Guru tanpa akun login</small>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="admin-stat-icon-wrap stat-icon-purple">
                <i class="mdi mdi-school-outline"></i>
            </div>
            <div class="admin-stat-content">
                <span class="admin-stat-label">Total Program</span>
                <strong class="admin-stat-value">{{ $totalPrograms }}</strong>
                <small class="admin-stat-desc">Jenjang pendidikan aktif</small>
            </div>
        </article>
    </section>

    <section class="admin-section">
        <div class="admin-card admin-table-card">
            <div class="admin-table-card-header">
                <div class="admin-table-title-wrap">
                    <div class="admin-table-header-icon">
                        <i class="mdi mdi-account-group-outline"></i>
                    </div>
                    <div>
                        <h2 class="admin-table-card-title">Data Guru Terbaru</h2>
                        <p class="admin-table-card-subtitle">Daftar guru dan tutor yang terbaru ditambahkan</p>
                    </div>
                </div>
                <a class="admin-link-action" href="{{ route('admin.teachers.index') }}">
                    <span>Lihat Semua</span>
                    <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>

            @if ($latestTeachers->isNotEmpty())
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th class="col-num">#</th>
                                <th>NAMA</th>
                                <th>JABATAN</th>
                                <th>STATUS AKUN</th>
                                <th>ASSIGNMENT</th>
                                <th>DITAMBAHKAN</th>
                                <th class="text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestTeachers as $teacher)
                                @php
                                    $initials = collect(explode(' ', $teacher->name))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                        ->implode('');
                                    $avatarColors = ['avatar-red', 'avatar-purple', 'avatar-pink', 'avatar-blue', 'avatar-teal', 'avatar-amber'];
                                    $avatarClass = $avatarColors[$loop->index % count($avatarColors)];
                                @endphp
                                <tr>
                                    <td class="col-num">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="admin-teacher-cell">
                                            @if ($teacher->photo)
                                                <img
                                                    src="{{ asset('storage/' . ltrim($teacher->photo, '/')) }}"
                                                    alt="{{ $teacher->name }}"
                                                    class="admin-avatar-img"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                >
                                                <div class="admin-avatar {{ $avatarClass }}" aria-hidden="true" style="display: none;">
                                                    {{ $initials ?: 'GR' }}
                                                </div>
                                            @else
                                                <div class="admin-avatar {{ $avatarClass }}" aria-hidden="true">
                                                    {{ $initials ?: 'GR' }}
                                                </div>
                                            @endif
                                            <a class="admin-teacher-name" href="{{ route('admin.teachers.show', $teacher) }}">
                                                {{ $teacher->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="admin-text-secondary">{{ $teacher->position ?: 'Tenaga Pendidik' }}</span>
                                    </td>
                                    <td>
                                        @if ($teacher->user)
                                            <span class="admin-badge admin-badge-success">Memiliki Akun</span>
                                        @else
                                            <span class="admin-badge admin-badge-warning">Belum Memiliki Akun</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="admin-assignment-text">
                                            {{ $teacher->teacherAssignments->count() }} assignment
                                        </span>
                                    </td>
                                    <td>
                                        <span class="admin-text-date">
                                            {{ $teacher->created_at ? $teacher->created_at->locale('id')->translatedFormat('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="admin-action-cell">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="admin-btn-action" title="Lihat Detail Guru">
                                                <i class="mdi mdi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="admin-empty">
                    <div class="admin-empty-icon"><i class="mdi mdi-account-off-outline"></i></div>
                    <p>Belum ada data guru.</p>
                    <a class="admin-btn admin-btn-primary" href="{{ route('admin.teachers.create') }}">
                        <i class="mdi mdi-plus"></i>
                        <span>Tambah Guru</span>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

