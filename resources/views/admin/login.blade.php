<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi — ISTexpo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0b1117;
            --accent: #008471;
            --text: #e6edf3;
            --text-muted: #8b949e;
            --border: rgba(255, 255, 255, 0.1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Manrope', sans-serif;
            background: var(--bg);
            color: var(--text);
            height: 100vh;
            display: grid;
            place-items: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: rgba(22, 27, 34, 0.7);
            border: 1px solid var(--border);
            padding: 48px;
            border-radius: 32px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }
        .logo {
            text-align: center;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 40px;
            color: #fff;
        }
        .form-group { margin-bottom: 24px; }
        label { display: block; font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase; }
        input {
            width: 100%;
            background: #0d1117;
            border: 1px solid var(--border);
            padding: 14px 20px;
            border-radius: 14px;
            color: #fff;
            font-family: inherit;
            outline: none;
            transition: 0.2s;
        }
        input:focus { border-color: var(--accent); box-shadow: 0 0 0 4px rgba(0, 132, 113, 0.1); }
        .btn {
            width: 100%;
            background: var(--accent);
            color: #fff;
            padding: 16px;
            border: none;
            border-radius: 14px;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 16px;
        }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .error { color: #f85149; font-size: 13px; margin-top: 8px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">ISTEXPO</div>
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>E-posta</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Şifre</label>
                <input type="password" name="password" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
