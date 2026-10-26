@extends('admin.layouts.app')

@section('title', 'Informasi Umum Profil Sekolah')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Profil Sekolah</span>
            <h1 class="admin-title">Informasi Umum</h1>
            <p class="admin-subtitle">Kelola informasi umum profil sekolah, identitas, logo, dan kontak resmi.</p>
        </div>
    </div>

    <section class="admin-card">
        <form action="{{ route('admin.school-profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <!-- Logo Sekolah with Live Preview -->
                <div class="admin-field admin-form-full">
                    <label for="logo">Logo Sekolah</label>
                    @php
                        $existingLogo = ($schoolProfile && $schoolProfile->logo) ? asset('storage/' . ltrim($schoolProfile->logo, '/')) : '';
                    @endphp
                    <div class="admin-upload-box">
                        <div class="admin-upload-flex">
                            <div class="admin-upload-preview-frame">
                                <img
                                    id="logoPreview"
                                    src="{{ $existingLogo }}"
                                    alt="Preview Logo"
                                    class="admin-upload-preview-img"
                                    style="{{ $existingLogo ? 'display: block;' : 'display: none;' }}"
                                    onerror="this.style.display='none'; document.getElementById('logoPlaceholder').style.display='flex';"
                                >
                                <div id="logoPlaceholder" class="admin-upload-preview-placeholder" style="{{ $existingLogo ? 'display: none;' : 'display: flex;' }}">
                                    <i class="mdi mdi-school-outline"></i>
                                    <span>Belum ada logo</span>
                                </div>
                            </div>

                            <div class="admin-upload-actions-wrap">
                                <div class="admin-upload-btn-row">
                                    <label for="logo" class="admin-btn admin-btn-outline admin-btn-sm" style="cursor: pointer;">
                                        <i class="mdi mdi-cloud-upload-outline"></i>
                                        <span>Pilih File Logo</span>
                                    </label>
                                    <button
                                        type="button"
                                        class="admin-btn-outline admin-btn-sm"
                                        id="logoClearBtn"
                                        style="display: none;"
                                        onclick="clearSingleImage('logo', 'logoPreview', 'logoPlaceholder', 'logoInfo', 'logoClearBtn', '{{ $existingLogo }}')"
                                    >
                                        <i class="mdi mdi-close"></i>
                                        Batal Pilihan
                                    </button>
                                </div>

                                <input
                                    id="logo"
                                    class="admin-file-hidden-input"
                                    type="file"
                                    name="logo"
                                    accept=".jpg,.jpeg,.png,.svg,.webp"
                                    data-max-size="2"
                                    onchange="previewSingleImage(this, 'logoPreview', 'logoPlaceholder', 'logoInfo', 'logoClearBtn', '{{ $existingLogo }}')"
                                >

                                <div id="logoInfo" class="admin-upload-status-info" style="display: none;"></div>
                                <p class="admin-upload-hint">Format yang didukung: JPG, PNG, WEBP, SVG. Maksimal ukuran file 2MB.</p>
                            </div>
                        </div>
                    </div>
                    @error('logo') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <!-- Banner Sekolah with Live Preview -->
                <div class="admin-field admin-form-full">
                    <label for="banner_image">Banner Sekolah</label>
                    @php
                        $existingBanner = ($schoolProfile && $schoolProfile->banner_image) ? asset('storage/' . ltrim($schoolProfile->banner_image, '/')) : '';
                    @endphp
                    <div class="admin-upload-box">
                        <div class="admin-upload-flex">
                            <div class="admin-upload-preview-frame frame-banner">
                                <img
                                    id="bannerPreview"
                                    src="{{ $existingBanner }}"
                                    alt="Preview Banner"
                                    class="admin-upload-preview-img"
                                    style="{{ $existingBanner ? 'display: block;' : 'display: none;' }}"
                                    onerror="this.style.display='none'; document.getElementById('bannerPlaceholder').style.display='flex';"
                                >
                                <div id="bannerPlaceholder" class="admin-upload-preview-placeholder" style="{{ $existingBanner ? 'display: none;' : 'display: flex;' }}">
                                    <i class="mdi mdi-image-area"></i>
                                    <span>Belum ada banner</span>
                                </div>
                            </div>

                            <div class="admin-upload-actions-wrap">
                                <div class="admin-upload-btn-row">
                                    <label for="banner_image" class="admin-btn admin-btn-outline admin-btn-sm" style="cursor: pointer;">
                                        <i class="mdi mdi-cloud-upload-outline"></i>
                                        <span>Pilih File Banner</span>
                                    </label>
                                    <button
                                        type="button"
                                        class="admin-btn-outline admin-btn-sm"
                                        id="bannerClearBtn"
                                        style="display: none;"
                                        onclick="clearSingleImage('banner_image', 'bannerPreview', 'bannerPlaceholder', 'bannerInfo', 'bannerClearBtn', '{{ $existingBanner }}')"
                                    >
                                        <i class="mdi mdi-close"></i>
                                        Batal Pilihan
                                    </button>
                                </div>

                                <input
                                    id="banner_image"
                                    class="admin-file-hidden-input"
                                    type="file"
                                    name="banner_image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    data-max-size="4"
                                    onchange="previewSingleImage(this, 'bannerPreview', 'bannerPlaceholder', 'bannerInfo', 'bannerClearBtn', '{{ $existingBanner }}')"
                                >

                                <div id="bannerInfo" class="admin-upload-status-info" style="display: none;"></div>
                                <p class="admin-upload-hint">Format yang didukung: JPG, PNG, WEBP. Maksimal ukuran file 4MB.</p>
                            </div>
                        </div>
                    </div>
                    @error('banner_image') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="foundation_name">Nama Yayasan</label>
                    <input id="foundation_name" class="admin-input" name="foundation_name" value="{{ old('foundation_name', $schoolProfile->foundation_name ?? '') }}" placeholder="Contoh: Yayasan Al Falah Sumur Batu">
                    @error('foundation_name') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="school_name">Nama Sekolah <span style="color: #DC2626;">*</span></label>
                    <input id="school_name" class="admin-input" name="school_name" value="{{ old('school_name', $schoolProfile->school_name ?? '') }}" required placeholder="Contoh: PKBM Al Falah">
                    @error('school_name') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="tagline">Tagline Sekolah</label>
                    <input id="tagline" class="admin-input" name="tagline" value="{{ old('tagline', $schoolProfile->tagline ?? '') }}" placeholder="Contoh: Terdepan dalam Pendidikan Kesetaraan dan Kejuruan">
                    @error('tagline') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="description">Deskripsi Singkat</label>
                    <textarea id="description" class="admin-textarea" name="description" placeholder="Deskripsi ringkas profil PKBM Al Falah...">{{ old('description', $schoolProfile->description ?? '') }}</textarea>
                    @error('description') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="address">Alamat Lengkap</label>
                    <textarea id="address" class="admin-textarea" name="address" placeholder="Alamat lengkap lokasi sekolah...">{{ old('address', $schoolProfile->address ?? '') }}</textarea>
                    @error('address') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="phone">Nomor Telepon / WhatsApp</label>
                    <input id="phone" class="admin-input" name="phone" value="{{ old('phone', $schoolProfile->phone ?? '') }}" placeholder="Contoh: (021) 12345678 / 0812...">
                    @error('phone') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="email">Email Resmi</label>
                    <input id="email" class="admin-input" name="email" type="email" value="{{ old('email', $schoolProfile->email ?? '') }}" placeholder="info@pkbmalfalah.sch.id">
                    @error('email') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="maps_embed">Link Embed Google Maps</label>
                    <textarea id="maps_embed" class="admin-textarea" name="maps_embed" placeholder="https://www.google.com/maps/embed?pb=...">{{ old('maps_embed', $schoolProfile->maps_embed ?? '') }}</textarea>
                    @error('maps_embed') <div class="admin-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="admin-actions" style="margin-top: 2rem;">
                <button class="admin-btn" type="submit">
                    <i class="mdi mdi-content-save-outline"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
@endsection