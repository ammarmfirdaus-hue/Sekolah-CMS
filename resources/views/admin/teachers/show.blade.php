@extends('admin.layouts.app')

@section('title', 'Detail Guru')

@section('content')
    <div class="admin-page-header">
        <div>
            <span class="admin-kicker">Detail Guru</span>
            <h1 class="admin-title">{{ $teacher->name }}</h1>
            <p class="admin-subtitle">Kelola profil, assignment, dan akun login guru.</p>
        </div>
        <div class="admin-actions">
            <a class="admin-btn-soft" href="{{ route('admin.teachers.index') }}">Kembali</a>
            <a class="admin-btn" href="{{ route('admin.teachers.edit', $teacher) }}">Edit Guru</a>
        </div>
    </div>

    <div class="admin-detail-grid">
        <section class="admin-card">
            <span class="admin-kicker">Profil Guru</span>
            <dl class="admin-definition-list">
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
                    <dd>{{ $teacher->position ?: 'Belum tersedia' }}</dd>
                </div>
                <div>
                    <dt>Pendidikan</dt>
                    <dd>{{ $teacher->education ?: 'Belum tersedia' }}</dd>
                </div>
                <div>
                    <dt>Email Kontak</dt>
                    <dd>{{ $teacher->email ?: 'Belum tersedia' }}</dd>
                </div>
                <div>
                    <dt>Telepon</dt>
                    <dd>{{ $teacher->phone ?: 'Belum tersedia' }}</dd>
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
                    <dt>Bio</dt>
                    <dd>{{ $teacher->bio ?: 'Belum tersedia' }}</dd>
                </div>
            </dl>

            <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" style="margin-top: 1.2rem;" onsubmit="return confirm('Hapus guru ini? Akun guru terkait juga akan dihapus.');">
                @csrf
                @method('DELETE')
                <button class="admin-btn-danger" type="submit">Hapus Guru</button>
            </form>
        </section>

        <section class="admin-card">
            <span class="admin-kicker">Informasi Akun</span>

            @if ($teacher->user)
                <dl class="admin-definition-list">
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

                <div class="admin-actions" style="margin-top: 1.2rem;">
                    @if ($teacher->user->is_active)
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
                        <button class="admin-btn-secondary" type="submit">Reset Password</button>
                    </form>
                </div>
            @else
                <p><span class="admin-badge admin-badge-warning">Belum Memiliki Akun</span></p>
                <form method="POST" action="{{ route('admin.teachers.account.store', $teacher) }}">
                    @csrf
                    <div class="admin-field">
                        <label for="account_email">Email Login</label>
                        <input id="account_email" class="admin-input" name="email" type="email" value="{{ old('email', $teacher->email) }}" required>
                        @error('email') <div class="admin-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="admin-field" style="margin-top: 1rem;">
                        <label for="account_password">Password Sementara</label>
                        <input id="account_password" class="admin-input" name="password" type="text" placeholder="Kosongkan untuk generate otomatis">
                        @error('password') <div class="admin-error">{{ $message }}</div> @enderror
                    </div>
                    <button class="admin-btn" type="submit" style="margin-top: 1rem;">Buat Akun Guru</button>
                </form>
            @endif
        </section>
    </div>

    <section class="admin-card" style="margin-top: 1.2rem;">
        <div class="admin-page-header">
            <div>
                <span class="admin-kicker">Assignment Guru</span>
                <h2 class="admin-title" style="font-size: 1.55rem;">Program dan Mata Pelajaran</h2>
            </div>
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
                    @forelse ($teacher->teacherAssignments as $assignment)
                        <tr>
                            <td><span class="admin-badge">{{ $assignment->program?->name ?? 'Belum tersedia' }}</span></td>
                            <td>{{ $assignment->subject?->name ?? 'Belum tersedia' }}</td>
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
                            <td colspan="4">Belum ada assignment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
