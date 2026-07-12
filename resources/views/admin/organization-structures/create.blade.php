@extends('admin.layouts.app')

@section('title', 'Tambah Anggota Struktur Organisasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Struktur Organisasi</span>
            <h1 class="admin-title">Tambah Anggota</h1>
            <p class="admin-subtitle">Tambahkan anggota baru ke struktur organisasi.</p>
        </div>
    </div>

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.organization-structures.store') }}" enctype="multipart/form-data">
            @include('admin.organization-structures.partials.form', ['submitLabel' => 'Simpan'])
        </form>
    </section>
@endsection
