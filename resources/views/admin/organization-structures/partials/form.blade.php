@csrf

<div class="admin-form-grid">
    <div class="admin-field">
        <label for="name">Nama</label>
        <input id="name" class="admin-input" name="name" value="{{ old('name', $organizationStructure->name ?? '') }}" required>
        @error('name') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="position">Jabatan</label>
        <input id="position" class="admin-input" name="position" value="{{ old('position', $organizationStructure->position ?? '') }}" readonly style="background-color: var(--color-surface-soft); cursor: not-allowed;" required>
        @error('position') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="photo">Foto</label>
        @if(isset($organizationStructure) && $organizationStructure->photo)
            <div style="margin-bottom: 0.75rem;">
                <img src="{{ asset('storage/'.ltrim($organizationStructure->photo, '/')) }}" alt="Foto saat ini" style="max-width: 120px; max-height: 120px; border: 1px solid var(--color-border); border-radius: 8px; padding: 4px; background: #fff;">
            </div>
        @endif
        <input id="photo" class="admin-input" type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp">
        <small style="display: block; margin-top: 0.3rem; color: var(--color-muted);">Format: JPEG, PNG, WEBP. Maksimal 4MB.</small>
        @error('photo') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="is_active">Status</label>
        <select id="is_active" class="admin-select" name="is_active" required>
            <option value="1" @selected((string) old('is_active', isset($organizationStructure) ? (int) $organizationStructure->is_active : 1) === '1')>Aktif</option>
            <option value="0" @selected((string) old('is_active', isset($organizationStructure) ? (int) $organizationStructure->is_active : 1) === '0')>Non-Aktif</option>
        </select>
        @error('is_active') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="description">Deskripsi (opsional)</label>
        <textarea id="description" class="admin-textarea" name="description" rows="3">{{ old('description', $organizationStructure->description ?? '') }}</textarea>
        @error('description') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="admin-actions" style="margin-top: 1.2rem;">
    <button class="admin-btn" type="submit">{{ $submitLabel }}</button>
    <a class="admin-btn-soft" href="{{ route('admin.organization-structures.index') }}">Batal</a>
</div>
