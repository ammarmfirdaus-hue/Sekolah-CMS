@extends('admin.layouts.app')

@section('title', 'Manajemen Guru')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Manajemen Guru</span>
            <h1 class="admin-title">Daftar Guru</h1>
            <p class="admin-subtitle">Kelola profil guru, akun login guru, dan assignment pengajaran.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.teachers.create') }}">Tambah Guru</a>
    </div>

    <form class="admin-search" method="GET" action="{{ route('admin.teachers.index') }}">
        <input class="admin-input" name="search" value="{{ $search }}" placeholder="Cari nama, email, jabatan, atau email login guru">
        <button class="admin-btn-soft" type="submit">Cari</button>
        @if ($search !== '')
            <a class="admin-btn-soft" href="{{ route('admin.teachers.index') }}">Reset</a>
        @endif
    </form>

    <div class="admin-table-card">

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Status Akun</th>
                        <th>Assignment</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                        @php
                            $initials = collect(explode(' ', $teacher->name))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
                        @endphp
                        <tr>
                            <td>
                                @if ($teacher->photo)
                                    <img class="admin-avatar" src="{{ asset('storage/'.ltrim($teacher->photo, '/')) }}" alt="Foto {{ $teacher->name }}">
                                @else
                                    <span class="admin-avatar-placeholder">{{ $initials ?: 'GR' }}</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $teacher->name }}</strong><br>
                                <span class="admin-badge {{ $teacher->is_active ? '' : 'admin-badge-muted' }}">{{ $teacher->is_active ? 'Publik Aktif' : 'Publik Nonaktif' }}</span>
                            </td>
                            <td>{{ $teacher->email ?: 'Belum tersedia' }}</td>
                            <td>{{ $teacher->position ?: 'Belum tersedia' }}</td>
                            <td>
                                @if ($teacher->user)
                                    <span class="admin-badge {{ $teacher->user->is_active ? '' : 'admin-badge-danger' }}">{{ $teacher->user->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}</span>
                                    <br><small>{{ $teacher->user->email }}</small>
                                @else
                                    <span class="admin-badge-warning">Belum Memiliki Akun</span>
                                @endif
                            </td>
                            <td>{{ $teacher->teacherAssignments->count() }} assignment</td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn-soft" href="{{ route('admin.teachers.show', $teacher) }}">Detail</a>
                                    <a class="admin-btn-soft" href="{{ route('admin.teachers.edit', $teacher) }}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="admin-empty">
                                    <p>{{ $search ? "Tidak ada guru ditemukan untuk pencarian '".$search."'." : 'Belum ada data guru.' }}</p>
                                    @if(!$search)
                                        <a class="admin-btn" href="{{ route('admin.teachers.create') }}">Tambah Guru</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination" style="padding: var(--space-4);">
            {{ $teachers->links() }}
        </div>
    </div>
@endsection
