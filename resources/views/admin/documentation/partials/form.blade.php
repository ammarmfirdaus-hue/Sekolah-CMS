@csrf

<div class="admin-form-grid">
    <div class="admin-field">
        <label for="title">Judul Kegiatan</label>
        <input id="title" class="admin-input" name="title" value="{{ old('title', $documentationEvent->title ?? '') }}" required>
        @error('title') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="event_date">Tanggal Kegiatan</label>
        <input id="event_date" class="admin-input" type="date" name="event_date" value="{{ old('event_date', isset($documentationEvent) ? $documentationEvent->event_date?->format('Y-m-d') : '') }}" required>
        @error('event_date') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="location">Lokasi</label>
        <input id="location" class="admin-input" name="location" value="{{ old('location', $documentationEvent->location ?? '') }}">
        @error('location') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="is_published">Status Publikasi</label>
        <select id="is_published" class="admin-select" name="is_published" required>
            <option value="1" @selected((string) old('is_published', isset($documentationEvent) ? (int) $documentationEvent->is_published : 1) === '1')>Published</option>
            <option value="0" @selected((string) old('is_published', isset($documentationEvent) ? (int) $documentationEvent->is_published : 1) === '0')>Draft</option>
        </select>
        @error('is_published') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="description">Deskripsi Acara</label>
        <textarea id="description" class="admin-textarea" name="description" rows="4">{{ old('description', $documentationEvent->description ?? '') }}</textarea>
        @error('description') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <!-- Foto Tambahan / Upload (Single Flow) -->
    <div class="admin-field admin-form-full" style="background: var(--color-surface-soft); padding: 1.5rem; border-radius: var(--radius-md); border: 1px dashed var(--color-border); margin-top: 1rem;">
        <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--color-text);">
            {{ isset($documentationEvent) ? 'Upload Foto Tambahan' : 'Upload Foto Dokumentasi' }}
        </h3>
        
        <div class="admin-field">
            <label for="{{ isset($documentationEvent) ? 'new_photos' : 'photos' }}">Pilih Foto (Bisa pilih beberapa sekaligus)</label>
            <input id="{{ isset($documentationEvent) ? 'new_photos' : 'photos' }}" class="admin-input" type="file" name="{{ isset($documentationEvent) ? 'new_photos[]' : 'photos[]' }}" multiple accept="image/jpeg,image/png,image/jpg,image/webp" {{ !isset($documentationEvent) ? 'required' : '' }}>
            <small style="display: block; margin-top: 0.3rem; color: var(--color-muted);">Format: JPEG, PNG, WEBP. Maksimal 5MB per file. Dimensi ideal minimal 1200x800 px.</small>
            @error(isset($documentationEvent) ? 'new_photos' : 'photos') <div class="admin-error">{{ $message }}</div> @enderror
            @error(isset($documentationEvent) ? 'new_photos.*' : 'photos.*') <div class="admin-error">{{ $message }}</div> @enderror
        </div>

        <div class="admin-field" style="margin-top: 1rem;">
            <label for="{{ isset($documentationEvent) ? 'new_photos_caption' : 'general_caption' }}">Caption (Opsional, untuk foto terupload di atas)</label>
            <input id="{{ isset($documentationEvent) ? 'new_photos_caption' : 'general_caption' }}" class="admin-input" name="{{ isset($documentationEvent) ? 'new_photos_caption' : 'general_caption' }}" placeholder="Contoh: Kegiatan pembukaan dan sambutan">
            @error(isset($documentationEvent) ? 'new_photos_caption' : 'general_caption') <div class="admin-error">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

<div class="admin-actions" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border);">
    <button class="admin-btn" type="submit">{{ $submitLabel }}</button>
    <a class="admin-btn-soft" href="{{ route('admin.documentation-events.index') }}">Batal</a>
</div>
