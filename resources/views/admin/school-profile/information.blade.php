@extends('admin.layouts.app')

@section('title', 'Informasi Umum Profil Sekolah')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Profil Sekolah</span>
            <h1 class="admin-title">Informasi Umum</h1>
            <p class="admin-subtitle">Kelola informasi umum profil sekolah.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="admin-alert admin-alert-success">{{ session('success') }}</div>
    @endif

    <section class="admin-card">
        <form action="{{ route('admin.school-profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field admin-form-full">
                    <label>Logo Sekolah</label>
                    @if($schoolProfile && $schoolProfile->logo)
                        <div style="margin-bottom: 0.75rem;">
                            <img src="{{ asset('storage/' . $schoolProfile->logo) }}" alt="Logo saat ini" style="max-width: 120px; max-height: 120px; border: 1px solid #ddd; border-radius: 8px; padding: 8px; background: #fff;">
                        </div>
                    @else
                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem;">Belum ada logo</p>
                    @endif
                    <input id="logo" class="admin-input" type="file" name="logo" accept=".jpg,.jpeg,.png,.svg">
                    <small style="color: #6b7280; font-size: 0.75rem;">Format: JPG, PNG, SVG. Maksimal 2MB.</small>
                    @error('logo') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label>Banner Sekolah</label>
                    @if($schoolProfile && $schoolProfile->banner_image)
                        <div style="margin-bottom: 0.75rem;">
                            <img src="{{ asset('storage/' . $schoolProfile->banner_image) }}" alt="Banner saat ini" style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; border-radius: 8px; padding: 8px; background: #fff;">
                        </div>
                    @else
                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem;">Belum ada banner</p>
                    @endif
                    <input id="banner_image" class="admin-input" type="file" name="banner_image" accept=".jpg,.jpeg,.png">
                    <small style="color: #6b7280; font-size: 0.75rem;">Format: JPG, PNG. Maksimal 4MB.</small>
                    @error('banner_image') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="foundation_name">Nama Yayasan</label>
                    <input id="foundation_name" class="admin-input" name="foundation_name" value="{{ old('foundation_name', $schoolProfile->foundation_name ?? '') }}">
                    @error('foundation_name') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="school_name">Nama Sekolah</label>
                    <input id="school_name" class="admin-input" name="school_name" value="{{ old('school_name', $schoolProfile->school_name ?? '') }}" required>
                    @error('school_name') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="tagline">Tagline</label>
                    <input id="tagline" class="admin-input" name="tagline" value="{{ old('tagline', $schoolProfile->tagline ?? '') }}">
                    @error('tagline') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" class="admin-textarea" name="description">{{ old('description', $schoolProfile->description ?? '') }}</textarea>
                    @error('description') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="address">Alamat</label>
                    <textarea id="address" class="admin-textarea" name="address">{{ old('address', $schoolProfile->address ?? '') }}</textarea>
                    @error('address') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="phone">Telepon</label>
                    <input id="phone" class="admin-input" name="phone" value="{{ old('phone', $schoolProfile->phone ?? '') }}">
                    @error('phone') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="email">Email</label>
                    <input id="email" class="admin-input" name="email" type="email" value="{{ old('email', $schoolProfile->email ?? '') }}">
                    @error('email') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="maps_embed">Link Embed Maps</label>
                    <textarea id="maps_embed" class="admin-textarea" name="maps_embed">{{ old('maps_embed', $schoolProfile->maps_embed ?? '') }}</textarea>
                    @error('maps_embed') <div class="admin-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="admin-actions" style="margin-top: 1.2rem;">
                <button class="admin-btn" type="submit">Simpan</button>
            </div>
        </form>
    </section>
@endsection