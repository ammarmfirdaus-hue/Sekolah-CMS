@csrf

<div class="admin-form-grid">
    <div class="admin-field">
        <label for="name">Nama Guru</label>
        <input id="name" class="admin-input" name="name" value="{{ old('name', $teacher->name ?? '') }}" required>
        @error('name') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="slug">Slug</label>
        <input id="slug" class="admin-input" name="slug" value="{{ old('slug', $teacher->slug ?? '') }}" required>
        @error('slug') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="position">Jabatan</label>
        <input id="position" class="admin-input" name="position" value="{{ old('position', $teacher->position ?? '') }}">
        @error('position') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="education">Pendidikan</label>
        <input id="education" class="admin-input" name="education" value="{{ old('education', $teacher->education ?? '') }}">
        @error('education') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="email">Email Kontak</label>
        <input id="email" class="admin-input" name="email" type="email" value="{{ old('email', $teacher->email ?? '') }}">
        @error('email') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="phone">Telepon</label>
        <input id="phone" class="admin-input" name="phone" value="{{ old('phone', $teacher->phone ?? '') }}">
        @error('phone') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="photo">Path Foto</label>
        <input id="photo" class="admin-input" name="photo" value="{{ old('photo', $teacher->photo ?? '') }}">
        @error('photo') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field">
        <label for="is_active">Status Publik</label>
        <select id="is_active" class="admin-select" name="is_active" required>
            <option value="1" @selected((string) old('is_active', isset($teacher) ? (int) $teacher->is_active : 1) === '1')>Aktif</option>
            <option value="0" @selected((string) old('is_active', isset($teacher) ? (int) $teacher->is_active : 1) === '0')>Nonaktif</option>
        </select>
        @error('is_active') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-field admin-form-full">
        <label for="bio">Bio</label>
        <textarea id="bio" class="admin-textarea" name="bio">{{ old('bio', $teacher->bio ?? '') }}</textarea>
        @error('bio') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="admin-actions" style="margin-top: 1.2rem;">
    <button class="admin-btn" type="submit">{{ $submitLabel }}</button>
    <a class="admin-btn-soft" href="{{ isset($teacher) && $teacher->exists ? route('admin.teachers.show', $teacher) : route('admin.teachers.index') }}">Batal</a>
</div>
