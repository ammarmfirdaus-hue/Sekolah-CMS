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

    <section class="admin-card">
        <h2 class="admin-section-title" style="margin-bottom: 1.25rem;">Upload Foto Dokumentasi</h2>
        <form method="POST" action="{{ route('admin.documentation-events.media.store', $documentationEvent) }}" enctype="multipart/form-data">
            @csrf
            <div class="admin-field">
                <label for="photos">Pilih Foto (maksimal 10 file) <span style="color: #DC2626;">*</span></label>
                <div class="admin-upload-box">
                    <div class="admin-upload-actions-wrap">
                        <div class="admin-upload-btn-row">
                            <label for="photos" class="admin-btn admin-btn-outline admin-btn-sm" style="cursor: pointer;">
                                <i class="mdi mdi-image-multiple-outline"></i>
                                <span>Pilih Foto dari Perangkat</span>
                            </label>
                            <button
                                type="button"
                                class="admin-btn-outline admin-btn-sm"
                                id="photosClearBtn"
                                style="display: none;"
                                onclick="clearMultipleImages('photos', 'multiPhotosGrid', 'photosInfo', 'photosClearBtn')"
                            >
                                <i class="mdi mdi-close"></i>
                                Batal Semua Pilihan
                            </button>
                        </div>

                        <input
                            id="photos"
                            class="admin-file-hidden-input"
                            type="file"
                            name="photos[]"
                            multiple
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            required
                            onchange="previewMultipleImages(this, 'multiPhotosGrid', 'photosInfo', 'photosClearBtn')"
                        >

                        <div id="photosInfo" class="admin-upload-status-info" style="display: none;"></div>
                        <p class="admin-upload-hint">Format yang didukung: JPG, PNG, WEBP. Maksimal 10 file sekaligus, 4MB per file.</p>

                        <!-- Live Multi-image Preview Grid -->
                        <div id="multiPhotosGrid" class="admin-multi-preview-grid"></div>
                    </div>
                </div>
                @error('photos') <div class="admin-error">{{ $message }}</div> @enderror
                @error('photos.*') <div class="admin-error">{{ $message }}</div> @enderror
            </div>

            <div class="admin-field" style="margin-top: 1.5rem;">
                <label for="caption">Caption (opsional, digunakan untuk semua foto yang diupload)</label>
                <input id="caption" class="admin-input" name="caption" value="{{ old('caption') }}" placeholder="Contoh: Kegiatan belajar outdoor">
                @error('caption') <div class="admin-error">{{ $message }}</div> @enderror
            </div>

            <div style="margin-top: 1.75rem;">
                <button class="admin-btn" type="submit">
                    <i class="mdi mdi-upload"></i>
                    Upload Foto
                </button>
            </div>
        </form>
    </section>

    @if($documentationEvent->media->isNotEmpty())
    <section class="admin-card">
        <h2 class="admin-section-title" style="margin-bottom: 1.25rem;">Gallery Media ({{ $documentationEvent->media->count() }} foto)</h2>
        
        <div class="admin-media-grid">
            @foreach($documentationEvent->media as $media)
                <div class="admin-media-card">
                    <div class="admin-media-image-wrapper">
                        @if($media->path)
                            <img src="{{ $media->publicUrl() }}" alt="{{ $media->caption ?: $documentationEvent->title }}" class="admin-media-image">
                        @else
                            <div class="admin-media-placeholder">
                                <i class="mdi mdi-image-outline" style="font-size: 48px;"></i>
                            </div>
                        @endif
                        @if($media->is_featured)
                            <span class="admin-media-featured-badge">
                                <i class="mdi mdi-star"></i> Featured
                            </span>
                        @endif
                    </div>

                    <div class="admin-media-body">
                        <form method="POST" action="{{ route('admin.documentation-events.media.update', [$documentationEvent, $media]) }}" style="margin-bottom: 1rem;">
                            @csrf
                            @method('PATCH')
                            <label for="caption-{{ $media->id }}" style="font-size: 0.8rem; font-weight: 600; color: var(--color-muted); display: block; margin-bottom: 0.35rem;">Caption</label>
                            <div class="admin-caption-field">
                                <input id="caption-{{ $media->id }}" class="admin-input" name="caption" value="{{ $media->caption }}" placeholder="Caption foto" style="font-size: 0.85rem; padding: 0.55rem 0.85rem;">
                                <button class="admin-btn admin-btn-sm" type="submit">
                                    <i class="mdi mdi-content-save-outline"></i>
                                    Simpan
                                </button>
                            </div>
                        </form>

                        <div class="admin-media-actions">
                            @if(!$media->is_featured)
                                <form method="POST" action="{{ route('admin.documentation-events.media.set-featured', [$documentationEvent, $media]) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="admin-btn-featured admin-btn-sm" type="submit">
                                        <i class="mdi mdi-star-outline"></i>
                                        Jadikan Featured
                                    </button>
                                </form>
                            @else
                                <span class="admin-badge-featured-active">
                                    <i class="mdi mdi-star"></i>
                                    Featured Aktif
                                </span>
                            @endif

                            <form method="POST" action="{{ route('admin.documentation-events.media.destroy', [$documentationEvent, $media]) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button class="admin-btn-danger admin-btn-sm" type="submit">
                                    <i class="mdi mdi-delete-outline"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
@endsection
