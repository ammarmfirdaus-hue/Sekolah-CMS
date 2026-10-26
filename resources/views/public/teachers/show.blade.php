@extends('public.layouts.app')

@section('title', $teacher->name.' | Guru '.$schoolProfile?->school_name)
@section('meta_description', $teacher->bio ?: 'Profil guru dan tenaga pendidik.')

@section('content')
    @php
        $initials = collect(explode(' ', $teacher->name))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
        $phoneDigits = preg_replace('/\D+/', '', $teacher->phone ?? '');
    @endphp

    <header class="page-header teacher-page-header">
        <div class="container">
            <nav class="teacher-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('home') }}#guru">Guru</a>
                <span aria-hidden="true">/</span>
                <span>{{ $teacher->name }}</span>
            </nav>
            <span class="section-kicker section-kicker-light">Profil Tenaga Pendidik</span>
            <h1>{{ $teacher->name }}</h1>
            <p>{{ $teacher->position ?: 'Tenaga Pendidik' }}</p>
        </div>
    </header>

    <section class="section-spacing teacher-detail-section teacher-detail-overlap">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-4">
                    <aside class="teacher-profile-card">
                        @if ($teacher->photo)
                            <img class="teacher-detail-photo" src="{{ asset('storage/'.ltrim($teacher->photo, '/')) }}" alt="Foto {{ $teacher->name }}">
                        @elseif ($teacher->name)
                            <div class="teacher-detail-avatar" aria-hidden="true">{{ $initials ?: 'GR' }}</div>
                        @endif

                        <h2>{{ $teacher->name }}</h2>
                        <p class="teacher-detail-position">{{ $teacher->position ?: 'Tenaga Pendidik' }}</p>

                        <dl class="teacher-contact-list">
                            <div>
                                <dt>Pendidikan</dt>
                                <dd>{{ $teacher->education ?: 'Belum tersedia' }}</dd>
                            </div>
                            <div>
                                <dt>Email</dt>
                                <dd>
                                    @if (filled($teacher->email))
                                        <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                                    @else
                                        Belum tersedia
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt>Telepon</dt>
                                <dd>
                                    @if (filled($teacher->phone))
                                        <a href="tel:{{ $phoneDigits }}">{{ $teacher->phone }}</a>
                                    @else
                                        Belum tersedia
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </aside>
                </div>

                <div class="col-lg-8">
                    <article class="detail-content-card">
                        <span class="section-kicker">Ringkasan Profil</span>
                        <h2>Informasi Umum</h2>
                        <p>{{ $teacher->bio ?: 'Informasi profil guru belum tersedia.' }}</p>
                    </article>

                    <article class="detail-content-card mt-4">
                        <span class="section-kicker">Bidang Pengajaran</span>
                        <h2>Mata Pelajaran dan Program</h2>

                        @if ($teacher->teacherAssignments->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table teaching-table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Program/Jenjang</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teacher->teacherAssignments->sortBy('program.sort_order') as $assignment)
                                            <tr>
                                                <td><span class="outline-badge">{{ $assignment->program?->name ?? 'Belum tersedia' }}</span></td>
                                                <td>{{ $assignment->subject?->name ?? 'Belum tersedia' }}</td>
                                                <td>{{ $assignment->note ?: '—' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">Data pengajaran belum tersedia.</div>
                        @endif
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
