@extends('admin.layouts.app')

@section('title', 'Informasi Pendaftaran')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Pendaftaran</span>
            <h1 class="admin-title">Informasi Pendaftaran</h1>
            <p class="admin-subtitle">Kelola informasi dan konten halaman pendaftaran peserta didik.</p>
        </div>
    </div>



    <section class="admin-card">
        <form action="{{ route('admin.registration.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="is_open">Status Pendaftaran</label>
                    <select id="is_open" class="admin-select" name="is_open" required>
                        <option value="1" @selected(old('is_open', $registrationInfo?->is_open ?? 1) == 1)>Dibuka</option>
                        <option value="0" @selected(old('is_open', $registrationInfo?->is_open ?? 1) == 0)>Ditutup</option>
                    </select>
                    <!-- @if ($registrationInfo?->is_open)
                        <span class="admin-badge" style="margin-top: 0.5rem; display: inline-block;">Pendaftaran Dibuka</span>
                    @else
                        <span class="admin-badge admin-badge-danger" style="margin-top: 0.5rem; display: inline-block;">Pendaftaran Ditutup</span>
                    @endif -->
                    @error('is_open') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="title">Judul Halaman</label>
                    <input id="title" class="admin-input" name="title" value="{{ old('title', $registrationInfo?->title ?? '') }}" required>
                    @error('title') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="subtitle">Subtitle</label>
                    <input id="subtitle" class="admin-input" name="subtitle" value="{{ old('subtitle', $registrationInfo?->subtitle ?? '') }}">
                    @error('subtitle') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" class="admin-textarea" name="description" rows="4">{{ old('description', $registrationInfo?->description ?? '') }}</textarea>
                    @error('description') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="requirements">Persyaratan</label>
                    <textarea id="requirements" class="admin-textarea" name="requirements" rows="6">{{ old('requirements', $registrationInfo?->requirements ?? '') }}</textarea>
                    @error('requirements') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="process">Alur Pendaftaran</label>
                    <textarea id="process" class="admin-textarea" name="process" rows="6">{{ old('process', $registrationInfo?->process ?? '') }}</textarea>
                    @error('process') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="schedule">Jadwal Pendaftaran</label>
                    <textarea id="schedule" class="admin-textarea" name="schedule" rows="6">{{ old('schedule', $registrationInfo?->schedule ?? '') }}</textarea>
                    @error('schedule') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="contact_info">Informasi Kontak Pendaftaran</label>
                    <textarea id="contact_info" class="admin-textarea" name="contact_info" rows="3">{{ old('contact_info', $registrationInfo?->contact_info ?? '') }}</textarea>
                    @error('contact_info') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="cta_text">Teks Tombol CTA</label>
                    <input id="cta_text" class="admin-input" name="cta_text" value="{{ old('cta_text', $registrationInfo?->cta_text ?? '') }}" placeholder="Contoh: Hubungi Kami">
                    @error('cta_text') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="cta_url">URL / Anchor CTA</label>
                    <input id="cta_url" class="admin-input" name="cta_url" value="{{ old('cta_url', $registrationInfo?->cta_url ?? '') }}" placeholder="Contoh: #kontak atau https://...">
                    @error('cta_url') <div class="admin-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="admin-actions" style="margin-top: 1.2rem;">
                <button class="admin-btn" type="submit">Simpan</button>
            </div>
        </form>
    </section>
@endsection
