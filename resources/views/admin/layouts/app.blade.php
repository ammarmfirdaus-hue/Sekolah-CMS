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
                    <strong>PKBM Al Falah</strong>
                    <span>Admin CMS Sekolah</span>
                </span>
            </a>

            <nav class="admin-nav" aria-label="Navigasi admin">
                <a href="{{ route('admin.index') }}" @class(['active' => request()->routeIs('admin.index')])>Dashboard</a>
                <a href="{{ route('admin.teachers.index') }}" @class(['active' => request()->routeIs('admin.teachers.*')])>Guru</a>
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
</body>
</html>
