<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin CMS') — PKBM Al Falah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    @php
        $schoolProfile = \App\Models\SchoolProfile::query()->first();
        $schoolName = $schoolProfile?->school_name ?? 'PKBM Al Falah';
        $schoolLogo = $schoolProfile?->logo;
        $initials = collect(explode(' ', $schoolName))->filter()->take(2)->map(fn($p) => mb_strtoupper(mb_substr($p,0,1)))->implode('');
    @endphp

    <div class="admin-shell">

        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="admin-sidebar" aria-label="Navigasi Admin">

            {{-- Brand --}}
            <a class="admin-brand" href="{{ route('admin.index') }}">
                @if($schoolLogo)
                    <img class="admin-logo-img" src="{{ asset('storage/'.ltrim($schoolLogo,'/')) }}" alt="Logo {{ $schoolName }}">
                @else
                    <span class="admin-logo-initial" aria-hidden="true">{{ $initials ?: 'AF' }}</span>
                @endif
                <span class="admin-brand-text">
                    <span class="admin-brand-name">{{ $schoolName }}</span>
                    <span class="admin-brand-label">Admin CMS</span>
                </span>
            </a>

            {{-- Navigation --}}
            <nav class="admin-nav" aria-label="Menu utama">

                {{-- DASHBOARD --}}
                <div class="admin-nav-group">
                    <span class="admin-nav-group-label">Dashboard</span>
                    <a class="admin-nav-item @if(request()->routeIs('admin.index')) active @endif" href="{{ route('admin.index') }}">
                        Dashboard
                    </a>
                </div>

                {{-- WEBSITE --}}
                <div class="admin-nav-group">
                    <span class="admin-nav-group-label">Website</span>

                    {{-- Profil Sekolah — dropdown (4 sub-pages) --}}
                    <button type="button"
                        class="admin-nav-toggle @if(request()->routeIs('admin.school-profile.*') || request()->routeIs('admin.organization-structures.*')) active @endif"
                        aria-expanded="{{ (request()->routeIs('admin.school-profile.*') || request()->routeIs('admin.organization-structures.*')) ? 'true' : 'false' }}"
                        data-target="profilMenu">
                        <span>Profil Sekolah</span>
                        <i class="admin-nav-chevron" aria-hidden="true"></i>
                    </button>
                    <div class="admin-nav-sub @if(request()->routeIs('admin.school-profile.*') || request()->routeIs('admin.organization-structures.*')) open @endif" id="profilMenu">
                        <a class="admin-nav-sub-item @if(request()->routeIs('admin.school-profile.*')) active @endif" href="{{ route('admin.school-profile.information') }}">Informasi Umum</a>
                        <a class="admin-nav-sub-item @if(request()->routeIs('admin.organization-structures.*')) active @endif" href="{{ route('admin.organization-structures.index') }}">Struktur Organisasi</a>
                    </div>

                    {{-- Program Pendidikan — direct link (1 page) --}}
                    {{-- Placeholder until route exists --}}

                    {{-- Dokumentasi — direct link (1 page) --}}
                    <a class="admin-nav-item @if(request()->routeIs('admin.documentation-events.*')) active @endif" href="{{ route('admin.documentation-events.index') }}">
                        Dokumentasi
                    </a>

                    {{-- Pendaftaran — direct link (1 page) --}}
                    <a class="admin-nav-item @if(request()->routeIs('admin.registration.*')) active @endif" href="{{ route('admin.registration.information') }}">
                        Pendaftaran
                    </a>
                </div>

                {{-- GURU --}}
                <div class="admin-nav-group">
                    <span class="admin-nav-group-label">Guru</span>
                    <a class="admin-nav-item @if(request()->routeIs('admin.teachers.*')) active @endif" href="{{ route('admin.teachers.index') }}">
                        Data Guru
                    </a>
                </div>

            </nav>
        </aside>

        {{-- ===================== MAIN ===================== --}}
        <div class="admin-main">

            {{-- Topbar --}}
            <header class="admin-topbar">
                <div class="admin-topbar-user">
                    <span class="admin-topbar-name">{{ auth()->user()->name }}</span>
                    <span class="admin-role-badge">{{ auth()->user()->role->value }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="admin-btn-soft" type="submit">Logout</button>
                </form>
            </header>

            {{-- Flash Messages --}}
            <main class="admin-content" id="main-content">
                @if(session('success'))
                    <div class="admin-alert admin-alert-success" role="alert">{{ session('success') }}</div>
                @endif

                @if(session('status'))
                    <div class="admin-alert admin-alert-success" role="alert">{{ session('status') }}</div>
                @endif

                @if(session('error'))
                    <div class="admin-alert admin-alert-danger" role="alert">{{ session('error') }}</div>
                @endif

                @if(session('temporary_password'))
                    <div class="admin-alert admin-alert-warning" role="alert">
                        Password sementara: <strong>{{ session('temporary_password') }}</strong>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar dropdown toggles
            document.querySelectorAll('.admin-nav-toggle').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    var targetId = this.getAttribute('data-target');
                    var submenu  = document.getElementById(targetId);
                    var expanded = this.getAttribute('aria-expanded') === 'true';

                    this.setAttribute('aria-expanded', String(!expanded));
                    if (submenu) submenu.classList.toggle('open', !expanded);

                    // Persist state
                    try {
                        localStorage.setItem('nav-' + targetId, !expanded ? 'open' : 'closed');
                    } catch (e) {}
                });

                // Restore state from localStorage (only if not forced-open by active class)
                var targetId = toggle.getAttribute('data-target');
                var submenu  = document.getElementById(targetId);
                if (submenu && !submenu.classList.contains('open')) {
                    try {
                        var saved = localStorage.getItem('nav-' + targetId);
                        if (saved === 'open') {
                            submenu.classList.add('open');
                            toggle.setAttribute('aria-expanded', 'true');
                        }
                    } catch (e) {}
                }
            });
        });
    </script>
</body>
</html>
