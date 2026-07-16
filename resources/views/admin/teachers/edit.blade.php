@extends('admin.layouts.app')

@section('title', 'Edit Guru')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Manajemen Guru</span>
            <h1 class="admin-title">Edit Guru</h1>
            <p class="admin-subtitle">Perbarui data profil publik guru.</p>
        </div>
        <a class="admin-btn-soft" href="{{ route('admin.teachers.show', $teacher) }}">Kembali</a>
    </div>

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.teachers.partials.form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </section>
@endsection
