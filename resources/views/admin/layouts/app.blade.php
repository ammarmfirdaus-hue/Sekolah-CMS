<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin CMS') | PKBM Al Falah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ route('admin.index') }}">
                <span class="admin-logo">AF</span>
                <span>
                    <!-- <strong>PKBM Al Falah</strong> -->
                    <span>Admin CMS Sekolah</span>
                </span>
            </a>

            <nav class="admin-nav" aria-label="Navigasi admin">
                <a href="{{ route('admin.index') }}" @class(['active' => request()->routeIs('admin.index')])>Dashboard</a>
                
                <button type="button" class="admin-nav-dropdown-toggle" data-toggle="collapse" data-target="#websiteMenu" aria-expanded="true">
                    <span>Website</span>
                    <i class="admin-nav-chevron"></i>
                </button>
                <div class="admin-nav-subitems show" id="websiteMenu">
                    <a href="{{ route('admin.school-profile.information') }}" class="admin-nav-sub" @class(['active' => request()->routeIs('admin.school-profile.*')])>Informasi Umum</a>
                    <a href="{{ route('admin.organization-structures.index') }}" class="admin-nav-sub" @class(['active' => request()->routeIs('admin.organization-structures.*')])>Struktur Organisasi</a>
                </div>
                
                <button type="button" class="admin-nav-dropdown-toggle" data-toggle="collapse" data-target="#documentationMenu" aria-expanded="true">
                    <span>Dokumentasi</span>
                    <i class="admin-nav-chevron"></i>
                </button>
                <div class="admin-nav-subitems show" id="documentationMenu">
                    <a href="{{ route('admin.documentation-events.index') }}" class="admin-nav-sub" @class(['active' => request()->routeIs('admin.documentation-events.*')])>Daftar Dokumentasi</a>
                </div>

                <button type="button" class="admin-nav-dropdown-toggle" data-toggle="collapse" data-target="#registrationMenu" aria-expanded="true">
                    <span>Pendaftaran</span>
                    <i class="admin-nav-chevron"></i>
                </button>
                <div class="admin-nav-subitems show" id="registrationMenu">
                    <a href="{{ route('admin.registration.information') }}" class="admin-nav-sub" @class(['active' => request()->routeIs('admin.registration.*')])>Informasi Pendaftaran</a>
                </div>

                <button type="button" class="admin-nav-dropdown-toggle" data-toggle="collapse" data-target="#teachersMenu" aria-expanded="true">
                    <span>Guru</span>
                    <i class="admin-nav-chevron"></i>
                </button>
                <div class="admin-nav-subitems show" id="teachersMenu">
                    <a href="{{ route('admin.teachers.index') }}" class="admin-nav-sub" @class(['active' => request()->routeIs('admin.teachers.*')])>Data Guru</a>
                </div>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <p>{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="admin-btn-soft" type="submit">Logout</button>
                </form>
            </header>

            <main class="admin-content">
                @if (session('status'))
                    <div class="admin-alert">{{ session('status') }}</div>
                @endif

                @if (session('temporary_password'))
                    <div class="admin-alert admin-alert-warning">
                        Password sementara: <strong>{{ session('temporary_password') }}</strong>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggles = document.querySelectorAll('.admin-nav-dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const target = document.querySelector(targetId);
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    
                    this.setAttribute('aria-expanded', !isExpanded);
                    
                    if (target) {
                        target.classList.toggle('show');
                    }
                });
            });
        });
    </script>
</body>
</html>
