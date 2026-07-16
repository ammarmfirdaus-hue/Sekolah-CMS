@extends('admin.layouts.app')

@section('title', 'Detail Guru')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Manajemen Guru</span>
            <h1 class="admin-title">{{ $teacher->name }}</h1>
            <p class="admin-subtitle">Detail profil, assignment, dan akun login guru.</p>
        </div>
        <div class="admin-actions">
            <a class="admin-btn-soft" href="{{ route('admin.teachers.index') }}">Kembali</a>
            <a class="admin-btn" href="{{ route('admin.teachers.edit', $teacher) }}">Edit Guru</a>
        </div>
    </div>

    <div class="admin-detail-grid">
        {{-- Profil --}}
        <section class="admin-card">
            <span class="admin-kicker">Profil Guru</span>
            <dl class="admin-definition-list mt-4">
                <div>
                    <dt>Nama</dt>
                    <dd>{{ $teacher->name }}</dd>
                </div>
                <div>
                    <dt>Slug</dt>
                    <dd>{{ $teacher->slug }}</dd>
                </div>
                <div>
                    <dt>Jabatan</dt>
                    <dd>{{ $teacher->position ?: '—' }}</dd>
                </div>
                <div>
                    <dt>Pendidikan</dt>
                    <dd>{{ $teacher->education ?: '—' }}</dd>
                </div>
                <div>
                    <dt>Email Kontak</dt>
                    <dd>{{ $teacher->email ?: '—' }}</dd>
                </div>
                <div>
                    <dt>Telepon</dt>
                    <dd>{{ $teacher->phone ?: '—' }}</dd>
                </div>
                <div>
                    <dt>Status Publik</dt>
                    <dd>
                        <span class="admin-badge {{ $teacher->is_active ? '' : 'admin-badge-muted' }}">
                            {{ $teacher->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt>Foto</dt>
                    <dd>
                        @if($teacher->photo)
                            <img src="{{ asset('storage/'.ltrim($teacher->photo, '/')) }}"
                                alt="Foto {{ $teacher->name }}"
                                style="max-width:100px; border-radius:var(--radius-sm); margin-top:var(--space-1);">
                        @else
                            <span class="admin-badge-muted">Belum ada foto</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt>Bio</dt>
                    <dd>{{ $teacher->bio ?: '—' }}</dd>
                </div>
            </dl>

            <div class="mt-5">
                <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}"
                    onsubmit="return confirm('Hapus guru ini? Akun guru terkait juga akan dihapus.');">
                    @csrf
                    @method('DELETE')
                    <button class="admin-btn-danger" type="submit">Hapus Guru</button>
                </form>
            </div>
        </section>

        {{-- Akun --}}
        <section class="admin-card">
            <span class="admin-kicker">Informasi Akun</span>

            @if($teacher->user)
                <dl class="admin-definition-list mt-4">
                    <div>
                        <dt>Email Login</dt>
                        <dd>{{ $teacher->user->email }}</dd>
                    </div>
                    <div>
                        <dt>Role</dt>
                        <dd>{{ $teacher->user->role->value }}</dd>
                    </div>
                    <div>
                        <dt>Status Akun</dt>
                        <dd>
                            <span class="admin-badge {{ $teacher->user->is_active ? '' : 'admin-badge-danger' }}">
                                {{ $teacher->user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt>Wajib Ganti Password</dt>
                        <dd>{{ $teacher->user->must_change_password ? 'Ya' : 'Tidak' }}</dd>
                    </div>
                    <div>
                        <dt>Dibuat</dt>
                        <dd>{{ $teacher->user->created_at?->format('d M Y H:i') }}</dd>
                    </div>
                </dl>

                <div class="admin-actions mt-5">
                    @if($teacher->user->is_active)
                        <form method="POST" action="{{ route('admin.teachers.account.deactivate', $teacher) }}">
                            @csrf
                            @method('PATCH')
                            <button class="admin-btn-danger" type="submit">Nonaktifkan Akun</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.teachers.account.activate', $teacher) }}">
                            @csrf
                            @method('PATCH')
                            <button class="admin-btn" type="submit">Aktifkan Akun</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.teachers.account.reset-password', $teacher) }}">
                        @csrf
                        @method('PATCH')
                        <button class="admin-btn-soft" type="submit">Reset Password</button>
                    </form>
                </div>
            @else
                <p class="mt-4"><span class="admin-badge-warning">Belum Memiliki Akun</span></p>

                <form method="POST" action="{{ route('admin.teachers.account.store', $teacher) }}" class="mt-4">
                    @csrf
                    <div class="admin-field mb-4">
                        <label for="account_email" class="required">Email Login</label>
                        <input id="account_email" class="admin-input" name="email" type="email"
                            value="{{ old('email', $teacher->email) }}" required>
                        @error('email') <div class="admin-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="admin-field mb-4">
                        <label for="account_password">Password Sementara</label>
                        <input id="account_password" class="admin-input" name="password" type="text"
                            placeholder="Kosongkan untuk generate otomatis">
                        @error('password') <div class="admin-error">{{ $message }}</div> @enderror
                    </div>
                    <button class="admin-btn" type="submit">Buat Akun Guru</button>
                </form>
            @endif
        </section>
    </div>

    {{-- Assignments --}}
    <section class="admin-card mt-5">
        <div class="admin-section-header">
            <h2 class="admin-section-title">Assignment: Program &amp; Mata Pelajaran</h2>
            <a class="admin-btn" href="{{ route('admin.teachers.assignments.create', $teacher) }}">Tambah Assignment</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Mata Pelajaran</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teacher->teacherAssignments as $assignment)
                        <tr>
                            <td><span class="admin-badge">{{ $assignment->program?->name ?? '—' }}</span></td>
                            <td>{{ $assignment->subject?->name ?? '—' }}</td>
                            <td>{{ $assignment->note ?: '—' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.teachers.assignments.destroy', [$teacher, $assignment]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="admin-btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="admin-empty">
                                    <p>Belum ada assignment pengajaran untuk guru ini.</p>
                                    <a class="admin-btn" href="{{ route('admin.teachers.assignments.create', $teacher) }}">Tambah Assignment</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
