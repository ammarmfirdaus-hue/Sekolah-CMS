@extends('admin.layouts.app')

@section('title', 'Edit Anggota Struktur Organisasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Struktur Organisasi</span>
            <h1 class="admin-title">Edit Anggota</h1>
            <p class="admin-subtitle">Perbarui data anggota struktur organisasi.</p>
        </div>
    </div>

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.organization-structures.update', $organizationStructure) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.organization-structures.partials.form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </section>
@endsection
