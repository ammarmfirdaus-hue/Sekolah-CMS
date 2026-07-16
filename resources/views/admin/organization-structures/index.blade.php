@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Profil Sekolah</span>
            <h1 class="admin-title">Struktur Organisasi</h1>
            <p class="admin-subtitle">Kelola anggota struktur organisasi yang ditampilkan di halaman profil.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.organization-structures.create') }}">Tambah Anggota</a>
    </div>

    <div class="admin-table-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Ditambahkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        @php
                            $initials = collect(explode(' ', $member->name))->filter()->take(2)->map(fn($p) => mb_strtoupper(mb_substr($p,0,1)))->implode('');
                        @endphp
                        <tr>
                            <td>
                                <div class="admin-table-avatar-cell">
                                    @if($member->photo)
                                        <img class="admin-avatar"
                                            src="{{ asset('storage/'.ltrim($member->photo, '/')) }}"
                                            alt="Foto {{ $member->name }}">
                                    @else
                                        <span class="admin-avatar-placeholder">{{ $initials ?: '?' }}</span>
                                    @endif
                                    <strong>{{ $member->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $member->position }}</td>
                            <td>
                                @if ($member->is_active)
                                    <span class="admin-badge">Aktif</span>
                                @else
                                    <span class="admin-badge-muted">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $member->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn-soft" href="{{ route('admin.organization-structures.edit', $member) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.organization-structures.destroy', $member) }}"
                                        onsubmit="return confirm('Hapus anggota ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="admin-empty">
                                    <p>Belum ada anggota struktur organisasi.</p>
                                    <a class="admin-btn" href="{{ route('admin.organization-structures.create') }}">Tambah Anggota</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination" style="padding: var(--space-4);">
            {{ $members->links() }}
        </div>
    </div>
@endsection
