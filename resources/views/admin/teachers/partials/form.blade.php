@csrf

<div class="admin-form-grid">
    <div class="admin-field">
        <label for="name" class="required">Nama Guru</label>
        <input id="name" class="admin-input" name="name" type="text"
            value="{{ old('name', $teacher->name ?? '') }}" required>
        @error('name') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="slug" class="required">Slug</label>
        <input id="slug" class="admin-input" name="slug" type="text"
            value="{{ old('slug', $teacher->slug ?? '') }}" required>
        <span class="admin-help-text">Format: huruf kecil, angka, dan tanda hubung. Contoh: budi-santoso</span>
        @error('slug') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="position">Jabatan</label>
        <input id="position" class="admin-input" name="position" type="text"
            value="{{ old('position', $teacher->position ?? '') }}">
        @error('position') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="education">Pendidikan</label>
        <input id="education" class="admin-input" name="education" type="text"
            value="{{ old('education', $teacher->education ?? '') }}">
        @error('education') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="email">Email Kontak</label>
        <input id="email" class="admin-input" name="email" type="email"
            value="{{ old('email', $teacher->email ?? '') }}">
        @error('email') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="phone">Telepon</label>
        <input id="phone" class="admin-input" name="phone" type="text"
            value="{{ old('phone', $teacher->phone ?? '') }}">
        @error('phone') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="is_active" class="required">Status Publik</label>
        <select id="is_active" class="admin-select" name="is_active" required>
            <option value="1" @selected((string) old('is_active', isset($teacher) ? (int) $teacher->is_active : 1) === '1')>Aktif</option>
            <option value="0" @selected((string) old('is_active', isset($teacher) ? (int) $teacher->is_active : 1) === '0')>Nonaktif</option>
        </select>
        @error('is_active') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="photo">Foto Guru</label>
        @if(isset($teacher) && $teacher->photo)
            <div class="admin-upload-preview">
                <img class="admin-upload-preview-img"
                    src="{{ asset('storage/'.ltrim($teacher->photo, '/')) }}"
                    alt="Foto {{ $teacher->name }}"
                    id="photo-preview-img">
                <span class="admin-upload-preview-label">Foto saat ini. Pilih file baru untuk mengganti.</span>
            </div>
        @else
            <div class="admin-upload-preview" id="photo-preview" style="display:none;">
                <img class="admin-upload-preview-img" id="photo-preview-img" src="" alt="Preview">
                <span class="admin-upload-preview-label">Preview foto baru.</span>
            </div>
        @endif
        <input id="photo" class="admin-input" name="photo" type="file" accept=".jpg,.jpeg,.png,.webp"
            onchange="previewPhoto(this)">
        <span class="admin-help-text">Format: JPG, PNG, WebP. Maksimal 2MB. Kosongkan untuk mempertahankan foto saat ini.</span>
        @error('photo') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="bio">Bio</label>
        <textarea id="bio" class="admin-textarea" name="bio">{{ old('bio', $teacher->bio ?? '') }}</textarea>
        @error('bio') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="admin-actions mt-5">
    <button class="admin-btn" type="submit">{{ $submitLabel }}</button>
    <a class="admin-btn-soft" href="{{ isset($teacher) && $teacher->exists ? route('admin.teachers.show', $teacher) : route('admin.teachers.index') }}">Batal</a>
</div>

<script>
function previewPhoto(input) {
    var preview = document.getElementById('photo-preview');
    var img     = document.getElementById('photo-preview-img');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            if (img)   img.src = e.target.result;
            if (preview) preview.style.display = 'flex';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
