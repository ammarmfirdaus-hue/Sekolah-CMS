<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | PKBM Al Falah Sumur Batu</title>
    <style>
        body {
            align-items: center;
            background: #f4f7f2;
            color: #1f2937;
            display: flex;
            font-family: system-ui, sans-serif;
            justify-content: center;
            margin: 0;
            min-height: 100vh;
            padding: 1.5rem;
        }

        main {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            box-shadow: 0 18px 48px rgba(27, 94, 32, 0.12);
            max-width: 420px;
            padding: 2rem;
            width: 100%;
        }

        h1 {
            color: #1b5e20;
            margin: 0 0 0.5rem;
        }

        p {
            color: #6b7280;
            margin: 0 0 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        input[type="email"],
        input[type="password"] {
            border: 1px solid #d1d5db;
            border-radius: 0.6rem;
            box-sizing: border-box;
            margin-bottom: 1rem;
            padding: 0.75rem;
            width: 100%;
        }

        .remember {
            align-items: center;
            display: flex;
            font-weight: 400;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        button {
            background: #2e7d32;
            border: 0;
            border-radius: 999px;
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            padding: 0.8rem 1.25rem;
            width: 100%;
        }

        .error {
            color: #b91c1c;
            font-size: 0.875rem;
            margin: -0.5rem 0 1rem;
        }

        a {
            color: #2e7d32;
            display: inline-block;
            margin-top: 1.25rem;
        }
    </style>
</head>
<body>
    <main>
        <h1>Login</h1>
        <p>Masuk menggunakan akun yang telah dibuat oleh administrator.</p>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label class="remember">
                <input name="remember" type="checkbox" value="1">
                Ingat saya
            </label>

            <button type="submit">Masuk</button>
        </form>

        <a href="{{ route('home') }}">Kembali ke website</a>
    </main>
</body>
</html>
