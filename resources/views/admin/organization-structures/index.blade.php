@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Website</span>
            <h1 class="admin-title">Struktur Organisasi</h1>
            <p class="admin-subtitle">Kelola anggota struktur organisasi yang ditampilkan di halaman profil.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.organization-structures.create') }}">Tambah Anggota</a>
    </div>

    <section class="admin-card">
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
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/'.ltrim($member->photo, '/')) }}" alt="{{ $member->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div class="admin-avatar-placeholder">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                    @endif
                                    <strong>{{ $member->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $member->position }}</td>
                            <td>
                                @if ($member->is_active)
                                    <span class="admin-badge">Aktif</span>
                                @else
                                    <span class="admin-badge admin-badge-muted">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ $member->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn-soft" href="{{ route('admin.organization-structures.edit', $member) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.organization-structures.destroy', $member) }}" style="display: inline;" onsubmit="return confirm('Hapus anggota ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada anggota struktur organisasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $members->links() }}
        </div>
    </section>
@endsection
