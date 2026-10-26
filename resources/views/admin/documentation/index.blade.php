@extends('admin.layouts.app')

@section('title', 'Dokumentasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Dokumentasi</span>
            <h1 class="admin-title">Daftar Dokumentasi</h1>
            <p class="admin-subtitle">Kelola daftar kegiatan dokumentasi yang tampil di halaman publik.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.documentation-events.create') }}">
            <i class="mdi mdi-plus"></i>
            Tambah Dokumentasi
        </a>
    </div>

    <section class="admin-card admin-table-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="col-num">#</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Jumlah Media</th>
                        <th>Dibuat</th>
                        <th style="text-align: right; padding-right: 2rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($events as $event)
                        <tr>
                            <td class="col-num">{{ $loop->iteration + ($events->currentPage() - 1) * $events->perPage() }}</td>
                            <td>
                                <strong>{{ $event->title }}</strong>
                            </td>
                            <td>{{ $event->event_date->locale('id')->translatedFormat('d F Y') }}</td>
                            <td>{{ $event->location ?: '—' }}</td>
                            <td>
                                @if ($event->is_published)
                                    <span class="admin-badge admin-badge-success">Published</span>
                                @else
                                    <span class="admin-badge admin-badge-muted">Draft</span>
                                @endif
                            </td>
                            <td>
                                <span class="admin-badge admin-badge-warning">
                                    <i class="mdi mdi-image-multiple-outline" style="margin-right: 0.25rem;"></i>
                                    {{ $event->media_count }} media
                                </span>
                            </td>
                            <td>
                                <span class="admin-text-date">
                                    {{ $event->created_at->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td style="text-align: right; padding-right: 2rem;">
                                <div class="admin-actions" style="justify-content: flex-end;">
                                    <a class="admin-btn-edit admin-btn-sm" href="{{ route('admin.documentation-events.edit', $event) }}">
                                        <i class="mdi mdi-pencil-outline"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.documentation-events.destroy', $event) }}" style="display: inline;" onsubmit="return confirm('Hapus dokumentasi ini? Media terkait juga akan dihapus.');">
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
                            <td colspan="8" class="admin-empty">
                                <div class="admin-empty-icon">
                                    <i class="mdi mdi-image-multiple-outline"></i>
                                </div>
                                <p>Belum ada dokumentasi.</p>
                                <a class="admin-btn admin-btn-sm" href="{{ route('admin.documentation-events.create') }}">
                                    <i class="mdi mdi-plus"></i> Tambah Dokumentasi Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div style="padding: 1.25rem 2rem; border-top: 1px solid #F1F5F9;">
                {{ $events->links() }}
            </div>
        @endif
    </section>
@endsection
