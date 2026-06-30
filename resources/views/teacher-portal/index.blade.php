<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Guru</title>
</head>
<body>
    <main>
        <h1>Portal Guru</h1>
        <p>Fondasi akses guru aktif. Portal guru lengkap akan dibuat pada phase berikutnya.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </main>
</body>
</html>
