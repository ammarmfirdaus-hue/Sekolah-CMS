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
            <a class="admin-btn-outline" href="{{ route('admin.teachers.index') }}">
                <i class="mdi mdi-arrow-left"></i>
                Kembali
            </a>
            <a class="admin-btn" href="{{ route('admin.teachers.edit', $teacher) }}">
                <i class="mdi mdi-pencil-outline"></i>
                Edit Guru
            </a>
        </div>
    </div>

    <div class="admin-detail-grid">
        <section class="admin-card">
            <span class="admin-kicker">Profil Guru</span>
            <dl class="admin-definition-list">
                <div>
                    <dt>Nama</dt>
                    <dd><strong>{{ $teacher->name }}</strong></dd>
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
                        <span class="admin-badge {{ $teacher->is_active ? 'admin-badge-success' : 'admin-badge-muted' }}">
                            {{ $teacher->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt>Bio</dt>
                    <dd>{{ $teacher->bio ?: 'Belum tersedia' }}</dd>
                </div>
            </dl>

            <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" style="margin-top: 2rem;" onsubmit="return confirm('Hapus guru ini? Akun guru terkait juga akan dihapus.');">
                @csrf
                @method('DELETE')
                <button class="admin-btn-danger" type="submit">
                    <i class="mdi mdi-delete-outline"></i>
                    Hapus Guru
                </button>
            </form>
        </section>

        <section class="admin-card">
            <span class="admin-kicker">Informasi Akun</span>

            @if ($teacher->user)
                <dl class="admin-definition-list">
                    <div>
                        <dt>Email Login</dt>
                        <dd><strong>{{ $teacher->user->email }}</strong></dd>
                    </div>
                    <div>
                        <dt>Role</dt>
                        <dd><span class="admin-badge admin-badge-muted">{{ $teacher->user->role->value }}</span></dd>
                    </div>
                    <div>
                        <dt>Status Akun</dt>
                        <dd>
                            <span class="admin-badge {{ $teacher->user->is_active ? 'admin-badge-success' : 'admin-badge-danger' }}">
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

                <div class="admin-actions" style="margin-top: 2rem;">
                    @if ($teacher->user->is_active)
                        <form method="POST" action="{{ route('admin.teachers.account.deactivate', $teacher) }}">
                            @csrf
                            @method('PATCH')
                            <button class="admin-btn-danger" type="submit">
                                <i class="mdi mdi-account-off-outline"></i>
                                Nonaktifkan Akun
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.teachers.account.activate', $teacher) }}">
                            @csrf
                            @method('PATCH')
                            <button class="admin-btn" type="submit">
                                <i class="mdi mdi-account-check-outline"></i>
                                Aktifkan Akun
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.teachers.account.reset-password', $teacher) }}">
                        @csrf
                        @method('PATCH')
                        <button class="admin-btn-featured" type="submit">
                            <i class="mdi mdi-lock-reset"></i>
                            Reset Password
                        </button>
                    </form>
                </div>
            @else
                <div style="margin-bottom: 1.5rem;">
                    <span class="admin-badge admin-badge-warning">Belum Memiliki Akun</span>
                </div>
                <form method="POST" action="{{ route('admin.teachers.account.store', $teacher) }}">
                    @csrf
                    <div class="admin-field">
                        <label for="account_email">Email Login</label>
                        <input id="account_email" class="admin-input" name="email" type="email" value="{{ old('email', $teacher->email) }}" required>
                        @error('email') <div class="admin-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="admin-field" style="margin-top: 1.25rem;">
                        <label for="account_password">Password Sementara</label>
                        <input id="account_password" class="admin-input" name="password" type="text" placeholder="Kosongkan untuk generate otomatis">
                        @error('password') <div class="admin-error">{{ $message }}</div> @enderror
                    </div>
                    <button class="admin-btn" type="submit" style="margin-top: 1.75rem;">
                        <i class="mdi mdi-account-plus-outline"></i>
                        Buat Akun Guru
                    </button>
                </form>
            @endif
        </section>
    </div>

    <section class="admin-card admin-table-card" style="margin-top: 2rem;">
        <div class="admin-table-header">
            <div class="admin-table-title-wrap">
                <div class="admin-table-header-icon">
                    <i class="mdi mdi-book-open-page-variant-outline"></i>
                </div>
                <div>
                    <span class="admin-kicker">Assignment Guru</span>
                    <h2 class="admin-table-card-title">Program dan Mata Pelajaran</h2>
                    <p class="admin-table-card-subtitle">Daftar assignment pengajaran aktif guru ini.</p>
                </div>
            </div>
            <a class="admin-btn admin-btn-sm" href="{{ route('admin.teachers.assignments.create', $teacher) }}">
                <i class="mdi mdi-plus"></i>
                Tambah Assignment
            </a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Mata Pelajaran</th>
                        <th>Keterangan</th>
                        <th style="text-align: right; padding-right: 2rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teacher->teacherAssignments as $assignment)
                        <tr>
                            <td>
                                <span class="admin-badge admin-badge-success">{{ $assignment->program?->name ?? 'Belum tersedia' }}</span>
                            </td>
                            <td><strong>{{ $assignment->subject?->name ?? 'Belum tersedia' }}</strong></td>
                            <td>{{ $assignment->note ?: '—' }}</td>
                            <td style="text-align: right; padding-right: 2rem;">
                                <form method="POST" action="{{ route('admin.teachers.assignments.destroy', [$teacher, $assignment]) }}" style="display: inline;" onsubmit="return confirm('Hapus assignment ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="admin-btn-danger admin-btn-sm" type="submit">
                                        <i class="mdi mdi-delete-outline"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="admin-empty">
                                <p style="margin: 0;">Belum ada assignment program atau mata pelajaran untuk guru ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
