@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Website</span>
            <h1 class="admin-title">Struktur Organisasi</h1>
            <p class="admin-subtitle">Kelola anggota struktur organisasi yang ditampilkan di halaman profil.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.organization-structures.create') }}">
            <i class="mdi mdi-plus"></i>
            Tambah Anggota
        </a>
    </div>

    <section class="admin-card admin-table-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="col-num">#</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Ditambahkan</th>
                        <th style="text-align: right; padding-right: 2rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avatarColors = ['avatar-teal', 'avatar-purple', 'avatar-blue', 'avatar-amber', 'avatar-pink', 'avatar-red'];
                    @endphp
                    @forelse ($members as $member)
                        @php
                            $colorClass = $avatarColors[$loop->index % count($avatarColors)];
                            $initials = collect(explode(' ', $member->name))->filter()->take(2)->map(fn($p) => strtoupper(substr($p, 0, 1)))->implode('');
                        @endphp
                        <tr>
                            <td class="col-num">{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                            <td>
                                <div class="admin-teacher-cell">
                                    @if($member->photo)
                                        <img
                                            src="{{ asset('storage/'.ltrim($member->photo, '/')) }}"
                                            alt="{{ $member->name }}"
                                            class="admin-avatar-img"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >
                                        <div class="admin-avatar {{ $colorClass }}" style="display: none;">
                                            {{ $initials ?: 'AO' }}
                                        </div>
                                    @else
                                        <div class="admin-avatar {{ $colorClass }}">
                                            {{ $initials ?: 'AO' }}
                                        </div>
                                    @endif
                                    <strong>{{ $member->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $member->position }}</td>
                            <td>
                                @if ($member->is_active)
                                    <span class="admin-badge admin-badge-success">Aktif</span>
                                @else
                                    <span class="admin-badge admin-badge-muted">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="admin-text-date">
                                    {{ $member->created_at->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td style="text-align: right; padding-right: 2rem;">
                                <div class="admin-actions" style="justify-content: flex-end;">
                                    <a class="admin-btn-edit admin-btn-sm" href="{{ route('admin.organization-structures.edit', $member) }}">
                                        <i class="mdi mdi-pencil-outline"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.organization-structures.destroy', $member) }}" style="display: inline;" onsubmit="return confirm('Hapus anggota ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-btn-danger admin-btn-sm" type="submit">
                                            <i class="mdi mdi-delete-outline"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="admin-empty">
                                <div class="admin-empty-icon">
                                    <i class="mdi mdi-sitemap-outline"></i>
                                </div>
                                <p>Belum ada anggota struktur organisasi.</p>
                                <a class="admin-btn admin-btn-sm" href="{{ route('admin.organization-structures.create') }}">
                                    <i class="mdi mdi-plus"></i> Tambah Anggota Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div style="padding: 1.25rem 2rem; border-top: 1px solid #F1F5F9;">
                {{ $members->links() }}
            </div>
        @endif
    </section>
@endsection
