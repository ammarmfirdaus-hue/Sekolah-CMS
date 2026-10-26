@csrf

<div class="admin-form-grid">
    <div class="admin-field">
        <label for="name">Nama Guru <span style="color: #DC2626;">*</span></label>
        <input id="name" class="admin-input" name="name" value="{{ old('name', $teacher->name ?? '') }}" placeholder="Masukkan nama lengkap guru beserta gelar..." required>
        @error('name') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="slug">Slug URL <span style="color: #DC2626;">*</span></label>
        <input id="slug" class="admin-input" name="slug" value="{{ old('slug', $teacher->slug ?? '') }}" placeholder="nama-guru" required>
        @error('slug') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="position">Jabatan / Posisi</label>
        <input id="position" class="admin-input" name="position" value="{{ old('position', $teacher->position ?? '') }}" placeholder="Contoh: Guru Matematika & Wali Kelas">
        @error('position') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="education">Pendidikan Terakhir</label>
        <input id="education" class="admin-input" name="education" value="{{ old('education', $teacher->education ?? '') }}" placeholder="Contoh: S1 Pendidikan Matematika, UNJ">
        @error('education') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="email">Email Kontak</label>
        <input id="email" class="admin-input" name="email" type="email" value="{{ old('email', $teacher->email ?? '') }}" placeholder="email@pkbmalfalah.sch.id">
        @error('email') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="phone">Nomor Telepon / WhatsApp</label>
        <input id="phone" class="admin-input" name="phone" value="{{ old('phone', $teacher->phone ?? '') }}" placeholder="08xxxxxxxxxx">
        @error('phone') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="photo">Foto Guru</label>
        @php
            $existingTeacherPhoto = isset($teacher) && $teacher->photo ? asset('storage/'.ltrim($teacher->photo, '/')) : '';
        @endphp
        <div class="admin-upload-box">
            <div class="admin-upload-flex">
                <div class="admin-upload-preview-frame">
                    <img
                        id="teacherPhotoPreview"
                        src="{{ $existingTeacherPhoto }}"
                        alt="Preview Foto Guru"
                        class="admin-upload-preview-img"
                        style="{{ $existingTeacherPhoto ? 'display: block;' : 'display: none;' }}"
                        onerror="this.style.display='none'; document.getElementById('teacherPhotoPlaceholder').style.display='flex';"
                    >
                    <div id="teacherPhotoPlaceholder" class="admin-upload-preview-placeholder" style="{{ $existingTeacherPhoto ? 'display: none;' : 'display: flex;' }}">
                        <i class="mdi mdi-account-tie-outline"></i>
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
                            id="teacherPhotoClearBtn"
                            style="display: none;"
                            onclick="clearSingleImage('photo', 'teacherPhotoPreview', 'teacherPhotoPlaceholder', 'teacherPhotoInfo', 'teacherPhotoClearBtn', '{{ $existingTeacherPhoto }}')"
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
                        onchange="previewSingleImage(this, 'teacherPhotoPreview', 'teacherPhotoPlaceholder', 'teacherPhotoInfo', 'teacherPhotoClearBtn', '{{ $existingTeacherPhoto }}')"
                    >

                    <div id="teacherPhotoInfo" class="admin-upload-status-info" style="display: none;"></div>
                    <p class="admin-upload-hint">Format yang didukung: JPG, PNG, WEBP. Maksimal ukuran file 4MB.</p>
                </div>
            </div>
        </div>
        @error('photo') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="is_active">Status Publikasi <span style="color: #DC2626;">*</span></label>
        <select id="is_active" class="admin-select" name="is_active" required>
            <option value="1" @selected((string) old('is_active', isset($teacher) ? (int) $teacher->is_active : 1) === '1')>Aktif (Tampil di Website)</option>
            <option value="0" @selected((string) old('is_active', isset($teacher) ? (int) $teacher->is_active : 1) === '0')>Nonaktif (Disembunyikan)</option>
        </select>
        @error('is_active') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="bio">Biografi Singkat</label>
        <textarea id="bio" class="admin-textarea" name="bio" placeholder="Tuliskan biografi singkat dan rekam jejak guru...">{{ old('bio', $teacher->bio ?? '') }}</textarea>
        @error('bio') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="admin-actions" style="margin-top: 2rem;">
    <button class="admin-btn" type="submit">
        <i class="mdi mdi-content-save-outline"></i>
        {{ $submitLabel }}
    </button>
    <a class="admin-btn-outline" href="{{ isset($teacher) && $teacher->exists ? route('admin.teachers.show', $teacher) : route('admin.teachers.index') }}">
        Batal
    </a>
</div>
