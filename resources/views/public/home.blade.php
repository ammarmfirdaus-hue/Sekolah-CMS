@extends('public.layouts.app')

@section('title', ($schoolProfile?->school_name ?? 'Sekolah').' | Website Resmi')

@section('content')
@php
$schoolName = $schoolProfile?->school_name ?? 'Sekolah';
$tagline = $schoolProfile?->tagline ?? 'Tagline sekolah';
$schoolDescription = $schoolProfile?->description ?? 'Deskripsi sekolah';
$bannerPath = $schoolProfile?->banner_image;
$bannerUrl = $bannerPath
? asset(str_starts_with($bannerPath, 'storage/') ? $bannerPath : 'storage/'.ltrim($bannerPath, '/'))
: null;
$profile = $sections->get('profil');
$vision = $sections->get('visi');
$mission = $sections->get('misi');
$history = $sections->get('sejarah');
$phoneDigits = preg_replace('/\D+/', '', $schoolProfile?->phone ?? '');
$whatsAppNumber = str_starts_with($phoneDigits, '0') ? '62'.substr($phoneDigits, 1) : $phoneDigits;
$mapsValue = trim($schoolProfile?->maps_embed ?? '');
$mapsUrl = null;

if ($mapsValue !== '') {
if (filter_var($mapsValue, FILTER_VALIDATE_URL)) {
$mapsUrl = $mapsValue;
} elseif (preg_match('/src=["\']([^"\']+)["\']/', $mapsValue, $matches)) {
$mapsUrl = html_entity_decode($matches[1]);
}

$mapsHost = $mapsUrl ? parse_url($mapsUrl, PHP_URL_HOST) : null;
if (! in_array($mapsHost, ['www.google.com', 'google.com', 'maps.google.com'], true)) {
$mapsUrl = null;
}
}
@endphp

<section
    id="beranda"
    class="hero-section"
    @if ($bannerUrl) style="--hero-background-image: url('{{ $bannerUrl }}')" @endif>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        @if(filled($schoolProfile?->foundation_name))
        <p class="hero-foundation">
            {{ $schoolProfile->foundation_name }}
        </p>
        @endif

        <h1 class="hero-title">
            {{ $schoolName }}
        </h1>

        <p class="hero-subtitle">
            {{ $tagline }}
        </p>

        <p class="hero-description">
            {{ $schoolDescription }}
        </p>

        <div class="hero-actions">
            <a href="#program" class="btn btn-accent-custom">Lihat Program</a>
            <a href="#kontak" class="btn btn-outline-light-custom">Hubungi Kami</a>
        </div>
    </div>
</section>

<section id="profil" class="section-spacing section-profile">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-7">
                <!-- <span class="section-kicker">Tentang Kami</span> -->
                <h2 class="section-title">{{ $profile?->title ?: 'Profil Sekolah' }}</h2>
                <p class="section-subtitle">{{ $profile?->subtitle ?: 'Lingkungan belajar yang ramah, terarah, dan mendukung perkembangan peserta didik.' }}</p>
                <div class="section-copy">
                    {{ $profile?->content ?: $schoolDescription }}
                </div>

                <div class="profile-highlights">
                    <article class="profile-highlight-card">
                        <span class="profile-highlight-icon" aria-hidden="true">01</span>
                        <div>
                            <h3>Lingkungan Belajar Ramah</h3>
                            <p>Suasana belajar yang tertib, nyaman, dan mendukung interaksi positif.</p>
                        </div>
                    </article>
                    <article class="profile-highlight-card">
                        <span class="profile-highlight-icon" aria-hidden="true">02</span>
                        <div>
                            <h3>Pendidikan Berjenjang</h3>
                            <p>Program pendidikan tersedia dari jenjang usia dini hingga menengah.</p>
                        </div>
                    </article>
                    <article class="profile-highlight-card">
                        <span class="profile-highlight-icon" aria-hidden="true">03</span>
                        <div>
                            <h3>Pembinaan Karakter</h3>
                            <p>Proses belajar turut menumbuhkan disiplin, tanggung jawab, dan kepedulian.</p>
                        </div>
                    </article>
                    <article class="profile-highlight-card">
                        <span class="profile-highlight-icon" aria-hidden="true">04</span>
                        <div>
                            <h3>Pendampingan Peserta Didik</h3>
                            <p>Pendampingan disesuaikan dengan tahap perkembangan dan kebutuhan belajar.</p>
                        </div>
                    </article>
                </div>
            </div>

            <div class="col-lg-5 profile-info-column">
                <div class="info-card">
                    <!-- <span class="info-card-label">Informasi Sekolah</span> -->
                    <h3>{{ $schoolName }}</h3>
                    <dl class="school-info-list">
                        <div>
                            <dt>Alamat</dt>
                            <dd>{{ $schoolProfile?->address ?? 'Alamat sekolah belum tersedia.' }}</dd>
                        </div>
                        <div>
                            <dt>Telepon</dt>
                            <dd>
                                @if (filled($schoolProfile?->phone))
                                <a href="tel:{{ preg_replace('/\\D+/', '', $schoolProfile->phone) }}">{{ $schoolProfile->phone }}</a>
                                @else
                                Belum tersedia
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd>
                                @if (filled($schoolProfile?->email))
                                <a href="mailto:{{ $schoolProfile->email }}">{{ $schoolProfile->email }}</a>
                                @else
                                Belum tersedia
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="visi-misi" class="section-spacing section-soft section-vision">
    <div class="container">
        <div class="section-heading text-center">
            <!-- <span class="section-kicker">Arah Pendidikan</span> -->
            <h2 class="section-title">Visi dan Misi</h2>
            <p class="section-subtitle">Landasan kami dalam mendampingi proses belajar dan perkembangan peserta didik.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <article class="vision-card h-100">
                    <h3>{{ $vision?->title ?: 'Visi' }}</h3>
                    <p>{{ $vision?->content ?: 'Menjadi lembaga pendidikan yang mendukung peserta didik agar berkarakter baik, berpengetahuan, dan mandiri.' }}</p>
                </article>
            </div>
            <div class="col-lg-6">
                <article class="mission-card h-100">
                    <h3>{{ $mission?->title ?: 'Misi' }}</h3>
                    @php
                    $missionItems = array_values(array_filter(
                    preg_split('/\r\n|\r|\n/', $mission?->content ?? '')
                    ));
                    @endphp
                    @if (count($missionItems) > 1)
                    <ol class="mission-list">
                        @foreach ($missionItems as $item)
                        <li>{{ $item }}</li>
                        @endforeach
                    </ol>
                    @else
                    <p>{{ $mission?->content ?: 'Menyelenggarakan pembelajaran yang terarah, ramah, dan sesuai kebutuhan peserta didik.' }}</p>
                    @endif
                </article>
            </div>
        </div>
    </div>
</section>

<section id="program" class="section-spacing section-program">
    <div class="container">
        <div class="section-heading text-center">
            <!-- <span class="section-kicker">Pilihan Jenjang</span> -->
            <h2 class="section-title">Program Pendidikan</h2>
            <p class="section-subtitle">Program pembelajaran yang disusun untuk mendukung kebutuhan peserta didik.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse ($programs as $program)
            <div class="col-md-6 col-lg-4">
                <article class="program-card h-100">
                    @if ($program->image)
                    <img class="program-image" src="{{ asset('storage/'.ltrim($program->image, '/')) }}" alt="Program {{ $program->name }}" loading="lazy">
                    @endif
                    <span class="program-label">Program Pendidikan</span>
                    <h3>{{ $program->name }}</h3>
                    <p>{{ $program->description ?: 'Informasi program akan diperbarui dalam waktu dekat.' }}</p>
                    <a href="#kontak" class="program-link">Tanyakan program <span aria-hidden="true">&rarr;</span></a>
                </article>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">Informasi program pendidikan belum tersedia.</div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<section id="sejarah" class="section-spacing section-soft section-history">
    <div class="container">
        <article class="history-card history-card-expanded">
            <div class="row align-items-stretch g-4 g-lg-5">
                <div class="col-lg-4">
                    @if ($history?->image)
                    <img class="history-image" src="{{ asset('storage/'.ltrim($history->image, '/')) }}" alt="{{ $history->title }}" loading="lazy">
                    @else
                    <div class="history-placeholder" aria-hidden="true">
                        <span>AF</span>
                        <div class="history-line history-line-one"></div>
                        <div class="history-line history-line-two"></div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-8">
                    <!-- <span class="section-kicker">Perjalanan Kami</span> -->
                    <h2 class="section-title">{{ $history?->title ?: 'Sejarah Singkat' }}</h2>
                    @if ($history?->subtitle)
                    <p class="section-subtitle">{{ $history->subtitle }}</p>
                    @endif
                    <p class="section-copy mb-0">
                        {{ $history?->content ?: 'Sekolah tumbuh dari kepedulian terhadap kebutuhan pendidikan masyarakat dan terus mengembangkan layanan belajar yang relevan.' }}
                    </p>

                    <div class="history-timeline">
                        <article>
                            <span aria-hidden="true"></span>
                            <div>
                                <h3>Awal Perjalanan</h3>
                                <p>Berawal dari perhatian terhadap kebutuhan layanan pendidikan di lingkungan masyarakat sekitar.</p>
                            </div>
                        </article>
                        <article>
                            <span aria-hidden="true"></span>
                            <div>
                                <h3>Pengembangan Layanan</h3>
                                <p>Program pembelajaran ditata secara bertahap agar tetap relevan bagi beragam jenjang pendidikan.</p>
                            </div>
                        </article>
                        <article>
                            <span aria-hidden="true"></span>
                            <div>
                                <h3>Komitmen Saat Ini</h3>
                                <p>Terus menghadirkan pendampingan belajar yang ramah, terarah, dan mudah diakses.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

<section id="struktur" class="section-spacing section-soft section-structure">
    <div class="container">
        <div class="section-heading text-center">
            <h2 class="section-title">Struktur Organisasi</h2>
            <p class="section-subtitle">Susunan kepengurusan {{ $schoolProfile?->school_name ?? 'PKBM Al Falah Sumur Batu' }}.</p>
        </div>

        @if($organizationStructures->isNotEmpty())
            <div class="structure-list">
                @foreach($organizationStructures as $member)
                    <article class="structure-card h-100">
                        <div class="structure-card-body">
                            @if($member->photo)
                                <img src="{{ asset('storage/'.ltrim($member->photo, '/')) }}" alt="{{ $member->name }}" class="structure-photo">
                            @else
                                <div class="structure-photo-placeholder">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                            @endif
                            <h3 class="structure-name">{{ $member->name }}</h3>
                            <p class="structure-position">{{ $member->position }}</p>
                            @if($member->description)
                                <p class="structure-description">{{ $member->description }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>Informasi struktur organisasi belum tersedia.</p>
            </div>
        @endif
    </div>
</section>

<section id="guru" class="section-spacing section-teacher">
    <div class="container">
        <div class="section-heading text-center">
            <!-- <span class="section-kicker">Pendamping Belajar</span> -->
            <h2 class="section-title">Guru &amp; Tenaga Pendidik</h2>
            <p class="section-subtitle">Tenaga pendidik yang mendampingi peserta didik dalam proses belajar.</p>
        </div>

        @if ($teachers->isNotEmpty())
        <div class="teacher-tools">
            <label class="visually-hidden" for="teacherSearch">Cari guru</label>
            <input id="teacherSearch" class="form-control" type="search" placeholder="Cari nama, jabatan, atau mata pelajaran">

            <label class="visually-hidden" for="programFilter">Filter program</label>
            <select id="programFilter" class="form-select">
                <option value="">Semua program</option>
                @foreach ($programs as $program)
                <option value="{{ $program->slug }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div id="teacherGrid" class="row g-4">
            @forelse ($teachers as $teacher)
            @php
            $teacherSubjects = $teacher->teacherAssignments
            ->pluck('subject.name')
            ->filter()
            ->unique()
            ->values();
            $teacherPrograms = $teacher->teacherAssignments
            ->pluck('program')
            ->filter()
            ->unique('id')
            ->values();
            $initials = collect(explode(' ', $teacher->name))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
            $searchText = mb_strtolower(implode(' ', [
            $teacher->name,
            $teacher->position,
            $teacher->education,
            $teacherSubjects->implode(' '),
            ]));
            @endphp
            <div
                class="col-md-6 col-lg-4 teacher-grid-item"
                data-search="{{ $searchText }}"
                data-programs="{{ $teacherPrograms->pluck('slug')->implode(' ') }}">
                <article class="teacher-card">
                    <div class="teacher-card-header">
                        @if ($teacher->photo)
                        <img class="teacher-avatar" src="{{ asset('storage/'.ltrim($teacher->photo, '/')) }}" alt="Foto {{ $teacher->name }}" loading="lazy">
                        @elseif ($teacher->name)
                        <div class="teacher-avatar-placeholder" aria-hidden="true">{{ $initials ?: 'GR' }}</div>
                        @endif
                        <div>
                            <h3>{{ $teacher->name }}</h3>
                            <p>{{ $teacher->position ?: 'Tenaga Pendidik' }}</p>
                        </div>
                    </div>

                    <div class="teacher-education">{{ $teacher->education ?: 'Informasi pendidikan belum tersedia.' }}</div>

                    <div class="teacher-meta">
                        <span class="teacher-meta-label">Mata Pelajaran</span>
                        <div class="badge-list">
                            @forelse ($teacherSubjects->take(3) as $subject)
                            <span class="soft-badge">{{ $subject }}</span>
                            @empty
                            <span class="text-muted-small">Belum tersedia</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="teacher-meta">
                        <span class="teacher-meta-label">Program</span>
                        <div class="badge-list">
                            @forelse ($teacherPrograms->take(4) as $program)
                            <span class="outline-badge">{{ $program->name }}</span>
                            @empty
                            <span class="text-muted-small">Belum tersedia</span>
                            @endforelse
                        </div>
                    </div>

                    <a class="btn btn-primary-custom w-100" href="{{ route('teachers.show', $teacher->slug) }}">
                        Lihat Detail
                    </a>
                </article>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">Data guru dan tenaga pendidik belum tersedia.</div>
            </div>
            @endforelse
        </div>

        <div id="teacherEmptyState" class="empty-state d-none mt-4">
            Guru dengan kata kunci atau program tersebut tidak ditemukan.
        </div>
    </div>
</section>

<section id="kontak" class="section-spacing contact-section section-contact">
    <div class="container">
        <div class="row align-items-stretch g-4 g-lg-5">
            <div class="col-lg-5">
                <!-- <span class="section-kicker section-kicker-light">Hubungi Kami</span> -->
                <h2 class="section-title text-white">Informasi Kontak Sekolah</h2>
                <p class="contact-intro">Silakan hubungi kami untuk memperoleh informasi lebih lanjut mengenai sekolah dan program pendidikan.</p>

                <div class="contact-list">
                    <div class="contact-item">
                        <span class="contact-icon" aria-hidden="true">📍</span>
                        <div>
                            <strong>Alamat</strong>
                            <p>{{ $schoolProfile?->address ?? 'Alamat sekolah belum tersedia.' }}</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon" aria-hidden="true">📞</span>
                        <div>
                            <strong>Telepon</strong>
                            <p>{{ $schoolProfile?->phone ?? 'Nomor telepon belum tersedia.' }}</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon" aria-hidden="true">✉️</span>
                        <div>
                            <strong>Email</strong>
                            <p>{{ $schoolProfile?->email ?? 'Email belum tersedia.' }}</p>
                        </div>
                    </div>
                </div>

                @if ($whatsAppNumber)
                <a
                    class="btn btn-accent-custom"
                    href="https://wa.me/{{ $whatsAppNumber }}"
                    target="_blank"
                    rel="noopener noreferrer">
                    Hubungi via WhatsApp
                </a>
                @endif
            </div>

            <div class="col-lg-7">
                <div class="map-card">
                    @if ($mapsUrl)
                    <iframe
                        src="{{ $mapsUrl }}"
                        title="Lokasi {{ $schoolName }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                    @else
                    <div class="map-placeholder">
                        <span class="map-pin" aria-hidden="true"></span>
                        <strong>Lokasi {{ $schoolName }}</strong>
                        <p>Peta interaktif lokasi sekolah akan ditampilkan di sini setelah data tersedia.</p>
                        <!-- <small>Google Maps belum ditambahkan.</small> -->
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('teacherSearch');
        const programFilter = document.getElementById('programFilter');
        const teacherItems = [...document.querySelectorAll('.teacher-grid-item')];
        const emptyState = document.getElementById('teacherEmptyState');

        const filterTeachers = () => {
            const searchTerm = (searchInput?.value || '').trim().toLowerCase();
            const selectedProgram = programFilter?.value || '';
            let visibleCount = 0;

            teacherItems.forEach((item) => {
                const matchesSearch = !searchTerm || item.dataset.search.includes(searchTerm);
                const programs = (item.dataset.programs || '').split(' ');
                const matchesProgram = !selectedProgram || programs.includes(selectedProgram);
                const isVisible = matchesSearch && matchesProgram;

                item.classList.toggle('d-none', !isVisible);
                if (isVisible) visibleCount += 1;
            });

            emptyState?.classList.toggle('d-none', visibleCount !== 0);
        };

        searchInput?.addEventListener('input', filterTeachers);
        programFilter?.addEventListener('change', filterTeachers);

        document.querySelectorAll('#publicNavbar .nav-link:not(.dropdown-toggle), #publicNavbar .nav-contact-button')
            .forEach((link) => {
                link.addEventListener('click', () => {
                    const navbar = document.getElementById('publicNavbar');
                    if (navbar?.classList.contains('show') && window.bootstrap) {
                        bootstrap.Collapse.getOrCreateInstance(navbar).hide();
                    }
                });
            });

        document.querySelectorAll('#publicNavbar .dropdown-item')
            .forEach((item) => {
                item.addEventListener('click', () => {
                    const navbar = document.getElementById('publicNavbar');
                    if (navbar?.classList.contains('show') && window.bootstrap) {
                        setTimeout(() => {
                            bootstrap.Collapse.getOrCreateInstance(navbar).hide();
                        }, 150);
                    }
                });
            });
    });
</script>
<style>
.structure-list {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
}

.structure-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    transition: transform 0.2s, box-shadow 0.2s;
    text-align: center;
}

.structure-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.structure-card-body {
    padding: 2rem 1.5rem;
}

.structure-photo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
    border: 3px solid var(--color-primary-soft);
}

.structure-photo-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: var(--color-primary-soft);
    color: var(--color-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    font-weight: 800;
}

.structure-name {
    color: var(--color-primary-dark);
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.structure-position {
    color: var(--color-primary);
    font-size: 0.88rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.structure-description {
    color: var(--color-muted);
    font-size: 0.85rem;
    line-height: 1.5;
    margin: 0;
}

.section-structure .empty-state p {
    color: var(--color-muted);
    text-align: center;
    padding: 2rem 0;
}

@media (max-width: 767.98px) {
    .structure-list {
        grid-template-columns: 1fr;
    }

    .structure-card-body {
        padding: 1.5rem 1rem;
    }
}
</style>
@endpush