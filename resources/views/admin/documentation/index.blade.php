@extends('admin.layouts.app')

@section('title', 'Dokumentasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Dokumentasi</span>
            <h1 class="admin-title">Daftar Dokumentasi</h1>
            <p class="admin-subtitle">Kelola daftar kegiatan dokumentasi yang tampil di halaman publik.</p>
        </div>
        <a class="admin-btn" href="{{ route('admin.documentation-events.create') }}">Tambah Dokumentasi</a>
    </div>

    <section class="admin-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Jumlah Media</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($events as $event)
                        <tr>
                            <td>
                                <strong>{{ $event->title }}</strong>
                            </td>
                            <td>{{ $event->event_date->locale('id')->translatedFormat('d F Y') }}</td>
                            <td>{{ $event->location ?: '—' }}</td>
                            <td>
                                @if ($event->is_published)
                                    <span class="admin-badge">Published</span>
                                @else
                                    <span class="admin-badge admin-badge-muted">Draft</span>
                                @endif
                            </td>
                            <td>{{ $event->media_count }} media</td>
                            <td>{{ $event->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn-soft" href="{{ route('admin.documentation-events.edit', $event) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.documentation-events.destroy', $event) }}" style="display: inline;" onsubmit="return confirm('Hapus dokumentasi ini? Media terkait juga akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada dokumentasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $events->links() }}
        </div>
    </section>
@endsection
