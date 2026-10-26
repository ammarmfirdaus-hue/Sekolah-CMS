@csrf

<div class="admin-form-grid">
    <div class="admin-field">
        <label for="name">Nama Anggota <span style="color: #DC2626;">*</span></label>
        <input id="name" class="admin-input" name="name" value="{{ old('name', $organizationStructure->name ?? '') }}" placeholder="Nama lengkap beserta gelar..." required>
        @error('name') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="position">Jabatan <span style="color: #DC2626;">*</span></label>
        <input id="position" class="admin-input" name="position" value="{{ old('position', $organizationStructure->position ?? '') }}" placeholder="Contoh: Pembina Yayasan, Kepala Sekolah, dll..." required>
        @error('position') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="photo">Foto Anggota</label>
        @php
            $existingPhoto = isset($organizationStructure) && $organizationStructure->photo ? asset('storage/'.ltrim($organizationStructure->photo, '/')) : '';
        @endphp
        <div class="admin-upload-box">
            <div class="admin-upload-flex">
                <div class="admin-upload-preview-frame">
                    <img
                        id="photoPreview"
                        src="{{ $existingPhoto }}"
                        alt="Preview Foto Anggota"
                        class="admin-upload-preview-img"
                        style="{{ $existingPhoto ? 'display: block;' : 'display: none;' }}"
                        onerror="this.style.display='none'; document.getElementById('photoPlaceholder').style.display='flex';"
                    >
                    <div id="photoPlaceholder" class="admin-upload-preview-placeholder" style="{{ $existingPhoto ? 'display: none;' : 'display: flex;' }}">
                        <i class="mdi mdi-account-circle-outline"></i>
                        <span>Belum ada foto</span>
                    </div>
                </div>

                <div class="admin-upload-actions-wrap">
                    <div class="admin-upload-btn-row">
                        <label for="photo" class="admin-btn admin-btn-outline admin-btn-sm" style="cursor: pointer;">
                            <i class="mdi mdi-cloud-upload-outline"></i>
                            <span>Pilih File Foto</span>
                        </label>
                        <button
                            type="button"
                            class="admin-btn-outline admin-btn-sm"
                            id="photoClearBtn"
                            style="display: none;"
                            onclick="clearSingleImage('photo', 'photoPreview', 'photoPlaceholder', 'photoInfo', 'photoClearBtn', '{{ $existingPhoto }}')"
                        >
                            <i class="mdi mdi-close"></i>
                            Batal Pilihan
                        </button>
                    </div>

                    <input
                        id="photo"
                        class="admin-file-hidden-input"
                        type="file"
                        name="photo"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        data-max-size="4"
                        onchange="previewSingleImage(this, 'photoPreview', 'photoPlaceholder', 'photoInfo', 'photoClearBtn', '{{ $existingPhoto }}')"
                    >

                    <div id="photoInfo" class="admin-upload-status-info" style="display: none;"></div>
                    <p class="admin-upload-hint">Format yang didukung: JPG, PNG, WEBP. Maksimal ukuran file 4MB.</p>
                </div>
            </div>
        </div>
        @error('photo') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="is_active">Status Keaktifan <span style="color: #DC2626;">*</span></label>
        <select id="is_active" class="admin-select" name="is_active" required>
            <option value="1" @selected((string) old('is_active', isset($organizationStructure) ? (int) $organizationStructure->is_active : 1) === '1')>Aktif</option>
            <option value="0" @selected((string) old('is_active', isset($organizationStructure) ? (int) $organizationStructure->is_active : 1) === '0')>Non-Aktif</option>
        </select>
        @error('is_active') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="description">Deskripsi (opsional)</label>
        <textarea id="description" class="admin-textarea" name="description" rows="3" placeholder="Deskripsi atau catatan singkat mengenai tugas/wewenang...">{{ old('description', $organizationStructure->description ?? '') }}</textarea>
        @error('description') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="admin-actions" style="margin-top: 2rem;">
    <button class="admin-btn" type="submit">
        <i class="mdi mdi-content-save-outline"></i>
        {{ $submitLabel }}
    </button>
    <a class="admin-btn-outline" href="{{ route('admin.organization-structures.index') }}">
        Batal
    </a>
</div>
