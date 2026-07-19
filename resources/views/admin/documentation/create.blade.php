@extends('admin.layouts.app')

@section('title', 'Tambah Dokumentasi')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Dokumentasi</span>
            <h1 class="admin-title">Tambah Dokumentasi</h1>
            <p class="admin-subtitle">Masukkan informasi kegiatan dokumentasi yang akan ditampilkan di halaman publik.</p>
        </div>
    </div>

    <section class="admin-card">
        <form method="POST" action="{{ route('admin.documentation-events.store') }}" enctype="multipart/form-data">
            @include('admin.documentation.partials.form', ['submitLabel' => 'Simpan Dokumentasi & Foto'])
        </form>
    </section>
@endsection
