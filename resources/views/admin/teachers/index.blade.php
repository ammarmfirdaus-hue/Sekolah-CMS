@extends('admin.layouts.app')

@section('title', 'Manajemen Guru')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Manajemen Guru</span>
            <h1 class="admin-title">Daftar Guru</h1>
            <p class="admin-subtitle">Kelola profil guru, akun login guru, dan assignment pengajaran.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.teachers.create') }}">
            <i class="mdi mdi-plus"></i>
            Tambah Guru
        </a>
    </div>

    <section class="admin-card admin-table-card">
        <div style="padding: 1.5rem 2rem 1.25rem;">
            <form class="admin-actions" method="GET" action="{{ route('admin.teachers.index') }}" style="max-width: 580px;">
                <input class="admin-input" name="search" value="{{ $search }}" placeholder="Cari nama, email, jabatan, atau akun login..." style="flex: 1;">
                <button class="admin-btn admin-btn-sm" type="submit">
                    <i class="mdi mdi-magnify"></i>
                    Cari
                </button>
                @if ($search !== '')
                    <a class="admin-btn-outline admin-btn-sm" href="{{ route('admin.teachers.index') }}">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="col-num">#</th>
                        <th>Guru</th>
                        <th>Email Kontak</th>
                        <th>Jabatan</th>
                        <th>Status Akun</th>
                        <th>Assignment</th>
                        <th style="text-align: right; padding-right: 2rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avatarColors = ['avatar-red', 'avatar-purple', 'avatar-blue', 'avatar-teal', 'avatar-amber', 'avatar-pink'];
                    @endphp
                    @forelse ($teachers as $teacher)
                        @php
                            $colorClass = $avatarColors[$loop->index % count($avatarColors)];
                            $initials = collect(explode(' ', $teacher->name))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
                        @endphp
                        <tr>
                            <td class="col-num">{{ $loop->iteration + ($teachers->currentPage() - 1) * $teachers->perPage() }}</td>
                            <td>
                                <div class="admin-teacher-cell">
                                    @if ($teacher->photo)
                                        <img
                                            class="admin-avatar-img"
                                            src="{{ asset('storage/'.ltrim($teacher->photo, '/')) }}"
                                            alt="Foto {{ $teacher->name }}"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >
                                        <span class="admin-avatar {{ $colorClass }}" style="display: none;">{{ $initials ?: 'GR' }}</span>
                                    @else
                                        <span class="admin-avatar {{ $colorClass }}">{{ $initials ?: 'GR' }}</span>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="admin-teacher-name">{{ $teacher->name }}</a>
                                        <div style="margin-top: 2px;">
                                            <span class="admin-badge {{ $teacher->is_active ? 'admin-badge-success' : 'admin-badge-muted' }}">
                                                {{ $teacher->is_active ? 'Publik Aktif' : 'Publik Nonaktif' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $teacher->email ?: '—' }}</td>
                            <td>{{ $teacher->position ?: '—' }}</td>
                            <td>
                                @if ($teacher->user)
                                    <span class="admin-badge {{ $teacher->user->is_active ? 'admin-badge-success' : 'admin-badge-danger' }}">
                                        {{ $teacher->user->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}
                                    </span>
                                    <div style="margin-top: 3px; font-size: 0.78rem; color: var(--color-muted);">{{ $teacher->user->email }}</div>
                                @else
                                    <span class="admin-badge admin-badge-warning">Belum Memiliki Akun</span>
                                @endif
                            </td>
                            <td>
                                <span class="admin-badge admin-badge-muted">
                                    {{ $teacher->teacherAssignments->count() }} assignment
                                </span>
                            </td>
                            <td style="text-align: right; padding-right: 2rem;">
                                <div class="admin-actions" style="justify-content: flex-end;">
                                    <a class="admin-btn-outline admin-btn-sm" href="{{ route('admin.teachers.show', $teacher) }}">
                                        <i class="mdi mdi-eye-outline"></i>
                                        Detail
                                    </a>
                                    <a class="admin-btn-edit admin-btn-sm" href="{{ route('admin.teachers.edit', $teacher) }}">
                                        <i class="mdi mdi-pencil-outline"></i>
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="admin-empty">
                                <div class="admin-empty-icon">
                                    <i class="mdi mdi-account-group-outline"></i>
                                </div>
                                <p>Data guru tidak ditemukan.</p>
                                <a class="admin-btn admin-btn-sm" href="{{ route('admin.teachers.create') }}">
                                    <i class="mdi mdi-plus"></i> Tambah Guru Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teachers->hasPages())
            <div style="padding: 1.25rem 2rem; border-top: 1px solid #F1F5F9;">
                {{ $teachers->links() }}
            </div>
        @endif
    </section>
@endsection
