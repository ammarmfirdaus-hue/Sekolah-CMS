@extends('admin.layouts.app')

@section('title', 'Tambah Assignment')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Assignment Guru</span>
            <h1 class="admin-title">Tambah Assignment</h1>
            <p class="admin-subtitle">Atur program dan mata pelajaran untuk {{ $teacher->name }}.</p>
        </div>
    </div>

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.teachers.assignments.store', $teacher) }}">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="program_id">Program</label>
                    <select id="program_id" class="admin-select" name="program_id" required>
                        <option value="">Pilih program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" @selected((string) old('program_id') === (string) $program->id)>{{ $program->name }}</option>
                        @endforeach
                    </select>
                    @error('program_id') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field">
                    <label for="subject_id">Mata Pelajaran</label>
                    <select id="subject_id" class="admin-select" name="subject_id" required>
                        <option value="">Pilih mata pelajaran</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected((string) old('subject_id') === (string) $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <div class="admin-error">{{ $message }}</div> @enderror
                </div>

                <div class="admin-field admin-form-full">
                    <label for="note">Keterangan</label>
                    <input id="note" class="admin-input" name="note" value="{{ old('note') }}">
                    @error('note') <div class="admin-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="admin-actions" style="margin-top: 1.2rem;">
                <button class="admin-btn" type="submit">Tambah Assignment</button>
                <a class="admin-btn-soft" href="{{ route('admin.teachers.show', $teacher) }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
