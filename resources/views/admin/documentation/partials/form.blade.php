@csrf

<div class="admin-form-grid">
    <div class="admin-field">
        <label for="title">Judul Kegiatan <span style="color: #DC2626;">*</span></label>
        <input id="title" class="admin-input" name="title" value="{{ old('title', $documentationEvent->title ?? '') }}" placeholder="Masukkan judul kegiatan..." required>
        @error('title') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="event_date">Tanggal Kegiatan <span style="color: #DC2626;">*</span></label>
        <input id="event_date" class="admin-input" type="date" name="event_date" value="{{ old('event_date', isset($documentationEvent) ? $documentationEvent->event_date?->format('Y-m-d') : '') }}" required>
        @error('event_date') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="location">Lokasi</label>
        <input id="location" class="admin-input" name="location" value="{{ old('location', $documentationEvent->location ?? '') }}" placeholder="Contoh: Aula Sekolah">
        @error('location') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="is_published">Status Publikasi <span style="color: #DC2626;">*</span></label>
        <select id="is_published" class="admin-select" name="is_published" required>
            <option value="1" @selected((string) old('is_published', isset($documentationEvent) ? (int) $documentationEvent->is_published : 1) === '1')>Published</option>
            <option value="0" @selected((string) old('is_published', isset($documentationEvent) ? (int) $documentationEvent->is_published : 1) === '0')>Draft</option>
        </select>
        @error('is_published') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="description">Deskripsi</label>
        <textarea id="description" class="admin-textarea" name="description" placeholder="Tuliskan deskripsi lengkap kegiatan dokumentasi...">{{ old('description', $documentationEvent->description ?? '') }}</textarea>
        @error('description') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="admin-actions" style="margin-top: 1.75rem;">
    <button class="admin-btn" type="submit">
        <i class="mdi mdi-content-save-outline"></i>
        {{ $submitLabel }}
    </button>
    <a class="admin-btn-outline" href="{{ route('admin.documentation-events.index') }}">Batal</a>
</div>
