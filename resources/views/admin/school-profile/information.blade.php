@extends('admin.layouts.app')

@section('title', 'Informasi Umum Profil Sekolah')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Profil Sekolah</span>
            <h1 class="admin-title">Informasi Umum</h1>
            <p class="admin-subtitle">Kelola identitas dan informasi kontak sekolah.</p>
        </div>
    </div>

    <section class="admin-card">
        <form action="{{ route('admin.school-profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">

                {{-- Logo --}}
                <div class="admin-field admin-form-full">
                    <label for="logo">Logo Sekolah</label>
                    @if($schoolProfile?->logo)
                        <div class="admin-upload-preview">
                            <img class="admin-upload-preview-img"
                                src="{{ asset('storage/'.$schoolProfile->logo) }}"
                                alt="Logo saat ini"
                                id="logo-preview-img">
                            <!-- <span class="admin-upload-preview-label">Logo saat ini. Pilih file baru untuk mengganti.</span> -->
                        </div>
                    @else
                        <div class="admin-upload-preview" id="logo-preview" style="display:none;">
                            <img class="admin-upload-preview-img" id="logo-preview-img" src="" alt="Preview">
                            <span class="admin-upload-preview-label">Preview logo baru.</span>
                        </div>
                    @endif
                    <input id="logo" class="admin-input" name="logo" type="file"
                        accept=".jpg,.jpeg,.png,.svg"
                        onchange="previewImage(this,'logo-preview-img','logo-preview')">
                    <span class="admin-help-text">Format: JPG, PNG, SVG. Maksimal 2MB.</span>
                    @error('logo') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Banner --}}
                <div class="admin-field admin-form-full">
                    <label for="banner_image">Banner Sekolah</label>
                    @if($schoolProfile?->banner_image)
                        <div class="admin-upload-preview">
                            <img class="admin-upload-preview-img"
                                src="{{ asset('storage/'.$schoolProfile->banner_image) }}"
                                alt="Banner saat ini"
                                id="banner-preview-img"
                                style="max-height:100px; max-width:300px;">
                            <!-- <span class="admin-upload-preview-label">Banner saat ini. Pilih file baru untuk mengganti.</span> -->
                        </div>
                    @else
                        <div class="admin-upload-preview" id="banner-preview" style="display:none;">
                            <img class="admin-upload-preview-img" id="banner-preview-img" src="" alt="Preview"
                                style="max-height:100px; max-width:300px;">
                            <span class="admin-upload-preview-label">Preview banner baru.</span>
                        </div>
                    @endif
                    <input id="banner_image" class="admin-input" name="banner_image" type="file"
                        accept=".jpg,.jpeg,.png"
                        onchange="previewImage(this,'banner-preview-img','banner-preview')">
                    <span class="admin-help-text">Format: JPG, PNG. Maksimal 4MB.</span>
                    @error('banner_image') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Nama Yayasan --}}
                <div class="admin-field">
                    <label for="foundation_name">Nama Yayasan</label>
                    <input id="foundation_name" class="admin-input" name="foundation_name" type="text"
                        value="{{ old('foundation_name', $schoolProfile->foundation_name ?? '') }}">
                    @error('foundation_name') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Nama Sekolah --}}
                <div class="admin-field">
                    <label for="school_name" class="required">Nama Sekolah</label>
                    <input id="school_name" class="admin-input" name="school_name" type="text"
                        value="{{ old('school_name', $schoolProfile->school_name ?? '') }}" required>
                    @error('school_name') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Tagline --}}
                <div class="admin-field admin-form-full">
                    <label for="tagline">Tagline</label>
                    <input id="tagline" class="admin-input" name="tagline" type="text"
                        value="{{ old('tagline', $schoolProfile->tagline ?? '') }}">
                    @error('tagline') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="admin-field admin-form-full">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" class="admin-textarea" name="description">{{ old('description', $schoolProfile->description ?? '') }}</textarea>
                    @error('description') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Alamat --}}
                <div class="admin-field admin-form-full">
                    <label for="address">Alamat</label>
                    <textarea id="address" class="admin-textarea" name="address">{{ old('address', $schoolProfile->address ?? '') }}</textarea>
                    @error('address') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Telepon --}}
                <div class="admin-field">
                    <label for="phone">Telepon</label>
                    <input id="phone" class="admin-input" name="phone" type="text"
                        value="{{ old('phone', $schoolProfile->phone ?? '') }}">
                    @error('phone') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="admin-field">
                    <label for="email">Email</label>
                    <input id="email" class="admin-input" name="email" type="email"
                        value="{{ old('email', $schoolProfile->email ?? '') }}">
                    @error('email') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                {{-- Maps Embed --}}
                <div class="admin-field admin-form-full">
                    <label for="maps_embed">Link Embed Google Maps</label>
                    <textarea id="maps_embed" class="admin-textarea" name="maps_embed">{{ old('maps_embed', $schoolProfile->maps_embed ?? '') }}</textarea>
                    <!-- <span class="admin-help-text">Tempel kode embed dari Google Maps (format iframe). Kosongkan jika tidak digunakan.</span> -->
                    @error('maps_embed') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

            </div>

            <div class="admin-actions mt-5">
                <button class="admin-btn" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    <script>
    function previewImage(input, imgId, wrapId) {
        var img  = document.getElementById(imgId);
        var wrap = document.getElementById(wrapId);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (img)  img.src = e.target.result;
                if (wrap) wrap.style.display = 'flex';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
@endsection