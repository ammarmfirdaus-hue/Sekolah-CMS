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
        <label for="description">Deskripsi</label>
        <textarea id="description" class="admin-textarea" name="description">{{ old('description', $documentationEvent->description ?? '') }}</textarea>
        @error('description') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="admin-actions" style="margin-top: 1.2rem;">
    <button class="admin-btn" type="submit">{{ $submitLabel }}</button>
    <a class="admin-btn-soft" href="{{ route('admin.documentation-events.index') }}">Batal</a>
</div>
