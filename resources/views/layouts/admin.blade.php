<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli — ISTexpo</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <style>
        :root {
            --admin-bg: #001829;             /* Derin lacivert arka plan */
            --admin-sidebar: #00223a;        /* Sidebar lacivert */
            --admin-card: rgba(0, 43, 73, 0.5);
            --admin-border: rgba(255, 255, 255, 0.08);
            --admin-accent: #F39200;         /* ISTexpo Turuncu */
            --admin-accent-hover: #e08000;
            --admin-navy: #002B49;           /* ISTexpo Lacivert */
            --admin-text: #e8eef4;
            --admin-text-muted: #7a9ab5;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Manrope', sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        aside {
            width: 280px;
            background: var(--admin-sidebar);
            border-right: 1px solid var(--admin-border);
            padding: 40px 24px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            box-shadow: 4px 0 24px rgba(0,0,0,0.3);
        }

        .logo {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 60px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
        }

        .logo-icon {
            width: 32px; height: 32px;
            background: var(--admin-accent);
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: var(--admin-navy);
        }
        .logo-icon svg { width: 18px; height: 18px; }

        nav ul { list-style: none; }
        nav li { margin-bottom: 8px; }
        nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--admin-text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
        }
        nav a:hover, nav a.active {
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
        }
        nav a.active {
            border-left: 3px solid var(--admin-accent);
            border-radius: 0 12px 12px 0;
            background: linear-gradient(90deg, rgba(243, 146, 0, 0.12) 0%, transparent 100%);
            color: #fff;
        }

        /* Main Content */
        main {
            flex: 1;
            margin-left: 280px;
            padding: 40px 60px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .avatar {
            width: 40px; height: 40px;
            background: #21262d;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 700;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: var(--admin-card);
            border: 1px solid var(--admin-border);
            padding: 24px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            transition: 0.2s;
        }
        .stat-card:hover { border-color: rgba(243,146,0,0.3); transform: translateY(-2px); }
        .stat-label { color: var(--admin-text-muted); font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; }
        .stat-value { font-size: 32px; font-weight: 800; }

        .content-section {
            background: var(--admin-card);
            border: 1px solid var(--admin-border);
            border-radius: 24px;
            padding: 32px;
        }

        .section-title { font-size: 20px; font-weight: 700; margin-bottom: 24px; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 16px; color: var(--admin-text-muted); font-size: 12px; text-transform: uppercase; border-bottom: 1px solid var(--admin-border); }
        td { padding: 16px; border-bottom: 1px solid var(--admin-border); font-size: 14px; }
        
        .badge {
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-success { background: rgba(35, 134, 54, 0.15); color: #3fb950; }

        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }
        .btn-primary { background: var(--admin-accent); color: var(--admin-navy); }
        .btn-primary:hover { background: var(--admin-accent-hover); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(243,146,0,0.3); }

        .admin-input {
            width: 100%;
            background: #0d1117;
            border: 1px solid var(--admin-border);
            padding: 12px 16px;
            border-radius: 12px;
            color: #fff;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }
        .admin-input:focus { border-color: var(--admin-accent); }

        /* Flatpickr Custom Styles */
        .flatpickr-input.form-control {
            background: #0d1117 !important;
            border: 1px solid var(--admin-border) !important;
            color: #fff !important;
            cursor: pointer;
        }
        .flatpickr-calendar {
            background: #0d1117 !important;
            border: 1px solid var(--admin-border) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
        }

        /* CKEditor Dark Theme */
        .ck-editor__editable_inline {
            min-height: 200px;
            background-color: #0d1117 !important;
            color: #fff !important;
            border: 1px solid var(--admin-border) !important;
        }
        .ck.ck-editor__main>.ck-editor__editable {
            background-color: #0d1117 !important;
        }
        .ck.ck-toolbar {
            background-color: #161b22 !important;
            border: 1px solid var(--admin-border) !important;
        }
        .ck.ck-toolbar__items {
            background-color: #161b22 !important;
        }
        .ck.ck-button {
            color: #fff !important;
        }
        .ck.ck-button:hover {
            background-color: #21262d !important;
        }
        .ck.ck-button.ck-on {
            background-color: var(--admin-accent) !important;
            color: var(--admin-navy) !important;
        }
    </style>
</head>
<body>
    <aside>
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ asset('img/icons/istexpo-home-logo.png') }}" alt="ISTexpo" style="max-height: 40px; width: auto; filter: brightness(0) invert(1);">
        </a>
        <nav>
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Panel</a></li>
                <li><a href="{{ route('admin.fairs.index') }}" class="{{ request()->routeIs('admin.fairs.index', 'admin.fairs.create', 'admin.fairs.edit') ? 'active' : '' }}">Fuarlar</a></li>
                <li><a href="{{ route('admin.fairs.featured') }}" class="{{ request()->routeIs('admin.fairs.featured') ? 'active' : '' }}">— Öne Çıkanlar</a></li>
                <li><a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">Hizmetler</a></li>
                <li><a href="{{ route('admin.representations.index') }}" class="{{ request()->routeIs('admin.representations.*') ? 'active' : '' }}">Temsilcilikler</a></li>
                <li><a href="{{ route('admin.inbox.index') }}" class="{{ request()->routeIs('admin.inbox.*') ? 'active' : '' }}">Gelen Kutusu</a></li>
                <li><a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">Haberler</a></li>
                <li><a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Ayarlar</a></li>
                <li style="margin-top: 40px;">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #f85149; cursor: pointer; padding: 12px 16px; font-weight: 700; font-size: 14px; font-family: inherit; width: 100%; text-align: left; display: flex; align-items: center; gap: 12px;">
                            Çıkış Yap
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <main>
        <header>
            <h1>@yield('header', 'Panel')</h1>
            <div class="user-profile">
                <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                <div class="avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
            </div>
        </header>

        @yield('content')
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('input[type="date"]', {
                locale: 'tr',
                dateFormat: 'Y-m-d',
                allowInput: true,
                altInput: true,
                altFormat: 'j F Y',
                altInputClass: 'admin-input',
                disableMobile: "true"
            });
        });

        // Initialize CKEditor
        document.querySelectorAll('.editor').forEach(el => {
            ClassicEditor
                .create(el, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>
