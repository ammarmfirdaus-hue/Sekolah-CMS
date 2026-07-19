@extends('admin.layouts.app')

@section('title', 'Edit Dokumentasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Dokumentasi</span>
            <h1 class="admin-title">Edit Dokumentasi</h1>
            <p class="admin-subtitle">Perbarui informasi kegiatan dokumentasi.</p>
        </div>
    </div>

    <form id="main-update-form" method="POST" action="{{ route('admin.documentation-events.update', $documentationEvent) }}" enctype="multipart/form-data">
        @method('PUT')
        
        <section class="admin-card">
            @include('admin.documentation.partials.form', ['submitLabel' => 'Simpan Seluruh Perubahan'])
        </section>

        @if($documentationEvent->media->isNotEmpty())
        <section class="admin-card" style="margin-top: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 class="admin-section-title" style="margin: 0;">Gallery Media ({{ $documentationEvent->media->count() }} foto)</h2>
                <div style="font-size: 0.9rem; color: var(--color-muted);">Foto yang tampil pertama otomatis akan menjadi Cover acara.</div>
            </div>
            
            <div class="admin-media-grid">
                @foreach($documentationEvent->media as $media)
                    <div class="admin-media-card" style="display: flex; flex-direction: column;">
                        <div class="admin-media-image-wrapper">
                            @if($media->path)
                                <img src="{{ $media->publicUrl() }}" alt="{{ $media->caption ?: $documentationEvent->title }}" class="admin-media-image" style="object-fit: cover;">
                            @else
                                <div class="admin-media-placeholder">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="admin-media-body" style="padding: 1rem; background: var(--color-surface); flex: 1; border-top: 1px solid var(--color-border); display: flex; flex-direction: column;">
                            <label for="caption-{{ $media->id }}" style="font-size: 0.8rem; font-weight: 600; color: var(--color-text); display: block; margin-bottom: 0.4rem;">Caption Spesifik</label>
                            
                            <!-- This input is naturally submitted by the master form wrapping everything -->
                            <input id="caption-{{ $media->id }}" class="admin-input" name="captions[{{ $media->id }}]" value="{{ $media->caption }}" placeholder="Kosongkan jika tidak perlu caption khusus" style="font-size: 0.85rem; padding: 0.5rem 0.7rem; margin-bottom: auto;">
                            
                            <div class="admin-actions" style="margin-top: 1rem; justify-content: flex-end;">
                                <button type="button" form="delete-form-{{ $media->id }}" class="admin-btn-danger" style="padding: 0.45rem 0.75rem; font-size: 0.8rem;" onclick="if(confirm('Hapus foto ini secara permanen?')) document.getElementById('delete-form-{{ $media->id }}').submit();">Hapus Foto</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
    </form>

    <!-- Hidden Delete Forms -->
    @if($documentationEvent->media->isNotEmpty())
        @foreach($documentationEvent->media as $media)
            <form id="delete-form-{{ $media->id }}" method="POST" action="{{ route('admin.documentation-events.media.destroy', [$documentationEvent, $media]) }}" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
@endsection
