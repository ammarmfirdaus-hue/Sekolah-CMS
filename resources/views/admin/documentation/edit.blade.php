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

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.documentation-events.update', $documentationEvent) }}">
            @method('PUT')
            @include('admin.documentation.partials.form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </section>

    <section class="admin-card" style="margin-top: 1.5rem;">
        <h2 class="admin-section-title" style="margin-bottom: 1rem;">Upload Foto Dokumentasi</h2>
        <form method="POST" action="{{ route('admin.documentation-events.media.store', $documentationEvent) }}" enctype="multipart/form-data">
            @csrf
            <div class="admin-field">
                <label for="photos">Pilih Foto (maksimal 10 file)</label>
                <input id="photos" class="admin-input" type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" required>
                <small style="display: block; margin-top: 0.3rem; color: var(--color-muted);">Format: JPEG, PNG, WEBP. Maksimal 4MB per file.</small>
                @error('photos') <div class="admin-error">{{ $message }}</div> @enderror
                @error('photos.*') <div class="admin-error">{{ $message }}</div> @enderror
            </div>

            <div class="admin-field" style="margin-top: 1rem;">
                <label for="caption">Caption (opsional, digunakan untuk semua foto yang diupload)</label>
                <input id="caption" class="admin-input" name="caption" value="{{ old('caption') }}" placeholder="Contoh: Kegiatan belajar outdoor">
                @error('caption') <div class="admin-error">{{ $message }}</div> @enderror
            </div>

            <div style="margin-top: 1rem;">
                <button class="admin-btn" type="submit">Upload Foto</button>
            </div>
        </form>
    </section>

    @if($documentationEvent->media->isNotEmpty())
    <section class="admin-card" style="margin-top: 1.5rem;">
        <h2 class="admin-section-title" style="margin-bottom: 1rem;">Gallery Media ({{ $documentationEvent->media->count() }} foto)</h2>
        
        <div class="admin-media-grid">
            @foreach($documentationEvent->media as $media)
                <div class="admin-media-card">
                    <div class="admin-media-image-wrapper">
                        @if($media->path)
                            <img src="{{ $media->publicUrl() }}" alt="{{ $media->caption ?: $documentationEvent->title }}" class="admin-media-image">
                        @else
                            <div class="admin-media-placeholder">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="48" height="48">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        @if($media->is_featured)
                            <span class="admin-media-featured-badge">Featured</span>
                        @endif
                    </div>

                    <div class="admin-media-body">
                        <form method="POST" action="{{ route('admin.documentation-events.media.update', [$documentationEvent, $media]) }}" style="margin-bottom: 0.75rem;">
                            @csrf
                            @method('PATCH')
                            <label for="caption-{{ $media->id }}" style="font-size: 0.8rem; font-weight: 600; color: var(--color-muted); display: block; margin-bottom: 0.3rem;">Caption</label>
                            <div style="display: flex; gap: 0.4rem;">
                                <input id="caption-{{ $media->id }}" class="admin-input" name="caption" value="{{ $media->caption }}" placeholder="Caption foto" style="font-size: 0.85rem; padding: 0.5rem 0.7rem;">
                                <button class="admin-btn-soft" type="submit" style="padding: 0.5rem 0.85rem; font-size: 0.8rem;">Simpan</button>
                            </div>
                        </form>

                        <div class="admin-actions" style="gap: 0.4rem;">
                            @if(!$media->is_featured)
                                <form method="POST" action="{{ route('admin.documentation-events.media.set-featured', [$documentationEvent, $media]) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="admin-btn-secondary" type="submit" style="padding: 0.45rem 0.75rem; font-size: 0.8rem;">Jadikan Featured</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.documentation-events.media.destroy', [$documentationEvent, $media]) }}" style="display: inline;" onsubmit="return confirm('Hapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="admin-btn-danger" type="submit" style="padding: 0.45rem 0.75rem; font-size: 0.8rem;">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
@endsection
