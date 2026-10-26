@extends('admin.layouts.app')

@section('title', 'Informasi Pendaftaran')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Pendaftaran</span>
            <h1 class="admin-title">Informasi Pendaftaran</h1>
            <p class="admin-subtitle">Kelola informasi, jadwal, dan konten alur pendaftaran peserta didik.</p>
        </div>
    </div>

    <section class="admin-card">
        <form action="{{ route('admin.registration.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="is_open">Status Pendaftaran <span style="color: #DC2626;">*</span></label>
                    <select id="is_open" class="admin-select" name="is_open" required>
                        <option value="1" @selected((string) old('is_open', $registrationInfo?->is_open ?? '') === '1')>Dibuka (Aktif Menerima Siswa Baru)</option>
                        <option value="0" @selected((string) old('is_open', $registrationInfo?->is_open ?? '') === '0')>Ditutup (Sementara)</option>
                    </select>
                    <div style="margin-top: 0.65rem;">
                        @if ($registrationInfo?->is_open)
                            <span class="admin-badge admin-badge-success">Pendaftaran Dibuka</span>
                        @else
                            <span class="admin-badge admin-badge-danger">Pendaftaran Ditutup</span>
                        @endif
                    </div>
                    @error('is_open') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="title">Judul Halaman Pendaftaran <span style="color: #DC2626;">*</span></label>
                    <input id="title" class="admin-input" name="title" value="{{ old('title', $registrationInfo?->title ?? '') }}" placeholder="Contoh: Penerimaan Peserta Didik Baru (PPDB)" required>
                    @error('title') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="subtitle">Subtitle / Subjudul</label>
                    <input id="subtitle" class="admin-input" name="subtitle" value="{{ old('subtitle', $registrationInfo?->subtitle ?? '') }}" placeholder="Contoh: Tahun Ajaran 2026/2027">
                    @error('subtitle') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="description">Deskripsi Lengkap</label>
                    <textarea id="description" class="admin-textarea" name="description" rows="4" placeholder="Penjelasan umum mengenai pendaftaran di PKBM Al Falah...">{{ old('description', $registrationInfo?->description ?? '') }}</textarea>
                    @error('description') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="requirements">Persyaratan Berkas & Calon Siswa</label>
                    <textarea id="requirements" class="admin-textarea" name="requirements" rows="6" placeholder="Tuliskan poin-poin persyaratan pendaftaran...">{{ old('requirements', $registrationInfo?->requirements ?? '') }}</textarea>
                    @error('requirements') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="process">Alur Pendaftaran</label>
                    <textarea id="process" class="admin-textarea" name="process" rows="6" placeholder="Langkah-langkah dari pengisian formulir hingga verifikasi...">{{ old('process', $registrationInfo?->process ?? '') }}</textarea>
                    @error('process') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="schedule">Jadwal & Periode Gelombang Pendaftaran</label>
                    <textarea id="schedule" class="admin-textarea" name="schedule" rows="6" placeholder="Tanggal dan jadwal gelombang pendaftaran...">{{ old('schedule', $registrationInfo?->schedule ?? '') }}</textarea>
                    @error('schedule') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="contact_info">Informasi Kontak & Panitia PPDB</label>
                    <textarea id="contact_info" class="admin-textarea" name="contact_info" rows="3" placeholder="Nomor kontak panitia atau narahubung pendaftaran...">{{ old('contact_info', $registrationInfo?->contact_info ?? '') }}</textarea>
                    @error('contact_info') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="cta_text">Teks Tombol Aksi (CTA)</label>
                    <input id="cta_text" class="admin-input" name="cta_text" value="{{ old('cta_text', $registrationInfo?->cta_text ?? '') }}" placeholder="Contoh: Hubungi Panitia PPDB">
                    @error('cta_text') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="cta_url">URL / Anchor Tujuan CTA</label>
                    <input id="cta_url" class="admin-input" name="cta_url" value="{{ old('cta_url', $registrationInfo?->cta_url ?? '') }}" placeholder="Contoh: https://wa.me/... atau #kontak">
                    @error('cta_url') <div class="admin-error">{{ $message }}</div> @enderror
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
