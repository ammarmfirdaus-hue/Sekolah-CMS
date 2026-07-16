@extends('admin.layouts.app')

@section('title', 'Tambah Guru')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Manajemen Guru</span>
            <h1 class="admin-title">Tambah Guru</h1>
            <p class="admin-subtitle">Masukkan data profil publik guru.</p>
        </div>
        <a class="admin-btn-soft" href="{{ route('admin.teachers.index') }}">Kembali</a>
    </div>

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
            @include('admin.teachers.partials.form', ['submitLabel' => 'Simpan Guru'])
        </form>
    </section>
@endsection
