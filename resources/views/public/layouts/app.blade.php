<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', $schoolProfile?->description ?? 'Website profil sekolah')">
    <title>@yield('title', $schoolProfile?->school_name ?? 'Sekolah')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg public-navbar sticky-top" aria-label="Navigasi utama">
        <div class="container">
            <a class="navbar-brand school-brand" href="{{ $homeUrl }}#beranda">
                @if ($schoolProfile?->logo)
                    <img
                        src="{{ asset('storage/'.ltrim($schoolProfile->logo, '/')) }}"
                        alt="Logo {{ $schoolName }}"
                        class="school-logo"
                    >
                @else
                    <span class="school-logo-placeholder" aria-hidden="true">AF</span>
                @endif
                <span class="school-brand-text">
                    <strong>{{ $schoolName }}</strong>
                    <!-- <small>Website Resmi Sekolah</small> -->
                </span>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#publicNavbar"
                aria-controls="publicNavbar"
                aria-expanded="false"
                aria-label="Buka navigasi"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="publicNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="{{ $homeUrl }}#beranda">Beranda</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ $homeUrl }}#profil">Profil Sekolah</a></li>
                            <li><a class="dropdown-item" href="{{ $homeUrl }}#visi-misi">Visi Misi</a></li>
                            <li><a class="dropdown-item" href="{{ $homeUrl }}#sejarah">Sejarah</a></li>
                            <li><a class="dropdown-item" href="{{ $homeUrl }}#struktur">Struktur Organisasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ $homeUrl }}#program">Program</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ $homeUrl }}#guru">Guru</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('documentation.index') }}">Dokumentasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('registration.index') }}">Pendaftaran</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary-custom btn-sm nav-contact-button" href="{{ $homeUrl }}#kontak">
                            Hubungi Kami
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="public-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="footer-brand">
                        @if ($schoolProfile?->logo)
                            <img
                                src="{{ asset('storage/'.ltrim($schoolProfile->logo, '/')) }}"
                                alt="Logo {{ $schoolName }}"
                                class="school-logo school-logo-footer"
                            >
                        @else
                            <span class="school-logo-placeholder school-logo-placeholder-light" aria-hidden="true">AF</span>
                        @endif
                        <div class="footer-brand-text">
                            <h2>{{ $schoolName }}</h2>
                            <p>{{$schoolProfile?->tagline ?? 'Tagline sekolah'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <h3>Menu</h3>
                    <ul class="footer-links">
                        <li><a href="{{ $homeUrl }}#profil">Profil Sekolah</a></li>
                        <li><a href="{{ $homeUrl }}#struktur">Struktur Organisasi</a></li>
                        <li><a href="{{ $homeUrl }}#program">Program Pendidikan</a></li>
                        <li><a href="{{ $homeUrl }}#guru">Guru</a></li>
                        <li><a href="{{ route('documentation.index') }}">Dokumentasi</a></li>
                        <li><a href="{{ route('registration.index') }}">Pendaftaran</a></li>
                        <li><a href="{{ $homeUrl }}#kontak">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-4">
                    <h3>Kontak</h3>
                    <ul class="footer-contact">
                        <li>{{ $schoolProfile?->address ?? 'Alamat sekolah belum tersedia.' }}</li>
                        <li>{{ $schoolProfile?->phone ?? 'Telepon belum tersedia.' }}</li>
                        <li>{{ $schoolProfile?->email ?? 'Email belum tersedia.' }}</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ now()->year }} {{ $schoolName }}.</span>
                <span>Website profil sekolah</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
