<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('ISTexpo — Global Events Portfolio'))</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ __('ISTexpo - Leading global events portfolio. Professional exhibition and trade show organizers.') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .lang-toggle {
            display: flex;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 100px;
            overflow: hidden;
            background: rgba(255,255,255,0.05);
        }

        /* Footer Override Styles */
        .footer {
            background: #333333 !important;
            padding: 80px 0 0 !important;
            color: #fff !important;
            font-size: 14px !important;
            position: relative;
            overflow: hidden;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: 100% auto;
            opacity: 0.25;
            filter: invert(1);
            pointer-events: none;
            z-index: 0;
        }
        .footer .wrap {
            position: relative;
            z-index: 1;
        }
        .footer-grid {
            display: grid !important;
            grid-template-columns: 1.2fr 1fr 0.8fr 1.2fr !important;
            gap: 40px !important;
            padding-bottom: 60px !important;
        }
        .footer h4 {
            color: #fff !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            margin-bottom: 30px !important;
            text-transform: uppercase !important;
            display: block !important;
            width: 100% !important;
        }
        .footer-brand .logo { 
            margin-bottom: 20px !important; 
            font-size: 32px !important;
            color: #fff !important;
        }
        .footer-brand .logo-icon {
            background: #fff !important;
            color: #333 !important;
            box-shadow: none !important;
        }
        .footer-brand .logo-icon svg {
            fill: #333 !important;
        }
        .footer-desc { 
            color: #bbb !important; 
            font-size: 14px !important; 
            line-height: 1.6 !important; 
        }
        .footer-links ul { list-style: none !important; padding: 0 !important; margin: 0 !important; }
        .footer-links li { 
            margin-bottom: 12px !important; 
            display: flex !important; 
            align-items: center !important; 
            gap: 10px !important;
            color: #bbb !important;
        }
        .footer-links li::before {
            content: '' !important;
            width: 8px !important;
            height: 8px !important;
            background: #777 !important;
            flex-shrink: 0 !important;
        }
        .footer-links a {
            color: #bbb !important;
            transition: 0.3s !important;
        }
        .footer-links a:hover {
            color: #fff !important;
            padding-left: 5px !important;
        }
        .footer-social {
            display: block !important;
        }
        .footer-social-icons {
            display: flex !important;
            gap: 15px !important;
            flex-wrap: wrap !important;
        }
        .footer-social-icons a {
            width: 36px !important;
            height: 36px !important;
            background: rgba(255,255,255,0.1) !important;
            display: grid !important;
            place-items: center !important;
            border-radius: 4px !important;
            transition: 0.3s !important;
            color: #fff !important;
            text-decoration: none !important;
        }
        .footer-social-icons a:hover {
            background: #F39200 !important;
            color: #002B49 !important;
        }
        .footer-contact-info {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .footer-contact-info li {
            display: flex !important;
            gap: 15px !important;
            margin-bottom: 15px !important;
            color: #bbb !important;
            align-items: flex-start !important;
        }
        .footer-contact-info svg {
            color: #fff !important;
            flex-shrink: 0 !important;
            margin-top: 3px !important;
        }
        .footer-bottom {
            background: #222 !important;
            padding: 20px 0 !important;
            font-size: 12px !important;
            color: #777 !important;
        }
        .footer-bottom .wrap {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        .footer-bottom-links {
            display: flex !important;
            gap: 20px !important;
        }
        .back-to-top {
            width: 40px !important;
            height: 40px !important;
            background: #444 !important;
            color: #fff !important;
            display: grid !important;
            place-items: center !important;
            position: absolute !important;
            right: 32px !important;
            bottom: 20px !important;
            transition: 0.3s !important;
            text-decoration: none !important;
        }
        .back-to-top:hover {
            background: #F39200 !important;
            color: #002B49 !important;
        }
        @media (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr !important; }
        }
        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr !important; }
        }

        .lang-toggle a {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            padding: 6px 16px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            color: rgba(255,255,255,0.7) !important;
            text-decoration: none !important;
            line-height: 1 !important;
            transition: all 0.2s;
        }
        .lang-toggle a.active {
            background: #f5b800 !important;
            color: #0f1d26 !important;
        }
        .lang-toggle a:hover:not(.active) {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
        }
    </style>
</head>
<body>
    <!-- Top Strip -->
    <div class="top-strip">
        <div class="top-strip-wrap">
            <div class="top-strip-left">
                <a href="mailto:info@istexpo.com">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    info@istexpo.com
                </a>
                <a href="tel:+902122758283">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    +90 (212) 275 82 83
                </a>
                <a href="tel:+902123558393">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    +90 (212) 355 83 93
                </a>
            </div>
            <div class="top-strip-right">
                <div class="lang-toggle">
                    <a href="{{ route('lang.switch', 'tr') }}" class="{{ app()->getLocale() == 'tr' ? 'active' : '' }}">TR</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header>
        <nav class="nav">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('img/icons/istexpo-home-logo.png') }}" alt="ISTexpo" style="max-height: 45px; width: auto;">
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                <li><a href="{{ route('fairs') }}">{{ __('Fairs') }}</a></li>
                <li><a href="{{ route('representations') }}">{{ __('Representations') }}</a></li>
                <li><a href="{{ route('supports') }}">{{ __('Supports') }}</a></li>
                <li><a href="{{ route('news') }}">{{ __('News') }}</a></li>
                <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
            </ul>

            <div class="nav-actions">
                <div class="search-container" style="display: flex; align-items: center;">
                    <form action="{{ route('search') }}" method="GET" id="searchForm" style="position: absolute; inset: 0; background: #fff; display: flex; align-items: center; padding: 0 32px; width: 100%; opacity: 0; visibility: hidden; transition: all 0.3s ease; z-index: 100;">
                        <div style="max-width: 1500px; margin: 0 auto; width: 100%; display: flex; align-items: center; gap: 20px;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--ink)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <input type="text" name="q" id="searchInput" placeholder="{{ __('Type to search...') }}" style="flex: 1; border: none; background: transparent; outline: none; font-size: 24px; font-family: inherit; color: var(--ink); font-weight: 500; padding: 20px 0;">
                            <button type="button" id="searchClose" style="background: transparent; border: none; color: var(--ink); cursor: pointer; padding: 10px; display: grid; place-items: center; transition: 0.3s; opacity: 0.6;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                    </form>
                    <button class="search-btn" id="searchTrigger" style="flex-shrink: 0; width: 44px; height: 44px; display: grid; place-items: center; border: 1px solid var(--line); border-radius: 50%; background: transparent; cursor: pointer; transition: 0.3s;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </button>
                </div>
                <a href="{{ route('contact') }}" class="cta-btn">
                    {{ __('Get in Touch') }}
                    <span class="arr">→</span>
                </a>
                <button class="mobile-menu-btn" id="mobileMenuBtn" style="display: none; width: 44px; height: 44px; background: transparent; border: 1px solid var(--line); border-radius: 50%; cursor: pointer; place-items: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="wrap">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h4>{{ __('BİZ KİMİZ?') }}</h4>
                    <a href="/" class="logo">
                        <img src="{{ asset('img/icons/istexpo-home-logo-white.png') }}" alt="ISTexpo" style="max-height: 45px; width: auto;">
                    </a>
                    <p class="footer-desc">{{ __('ISTexpo Fuarcılık Hizmetleri Ltd. Şti. ticari fuarlar ve etkinlik yönetimi konusunda deneyimli ekibi tarafından 2007 yılında kurulmuştur.') }}</p>
                </div>

                <div class="footer-links">
                    <h4>{{ __('HİZMETLERİMİZ') }}</h4>
                    <ul>
                        <li><a href="{{ route('about') }}">{{ __('Hakkımızda') }}</a></li>
                        <li><a href="{{ route('representations') }}">{{ __('Temsilciliklerimiz') }}</a></li>
                        <li><a href="{{ route('fairs') }}">{{ __('Fuarlar') }}</a></li>
                        <li><a href="{{ route('supports') }}">{{ __('Devlet Destekleri') }}</a></li>
                        <li><a href="{{ asset('documents/katilimci-kilavuzu.pdf') }}" download>{{ __('Katılımcı Kılavuzu') }}</a></li>
                        <li><a href="{{ route('news') }}">{{ __('Haberler') }}</a></li>
                        <li><a href="{{ route('contact') }}">{{ __('İletişim') }}</a></li>
                    </ul>
                </div>

                <div class="footer-social">
                    <h4>{{ __('SOSYAL MEDYA') }}</h4>
                    <div class="footer-social-icons">
                        <a href="{{ \App\Models\Setting::get('social_instagram') }}" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        <a href="{{ \App\Models\Setting::get('social_linkedin') }}" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                    </div>
                </div>

                <div class="footer-contact">
                    <h4>{{ __('BİZE ULAŞIN') }}</h4>
                    <div style="font-size: 15px; color: #fff; margin-bottom: 15px; font-weight: 600;">ISTexpo Fuarcılık Hizmetleri Ltd. Şti</div>
                    <ul class="footer-contact-info">
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>Ayazmaderesi Cad. Saral İş Merkezi<br>No: 5/A 34349 Beşiktaş/İstanbul</span>
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l2.27-2.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <a href="tel:+902122758283">+90 (212) 275 82 83</a>
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            <a href="tel:+902123558393">+90 (212) 355 83 93</a>
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <a href="mailto:info@istexpo.com">info@istexpo.com</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="wrap" style="position: relative;">
                <p>© {{ date('Y') }} | ISTEXPO FUARCILIK HİZMETLERİ LTD. ŞTİ.</p>
                <div class="footer-bottom-links">
                    <a href="{{ route('kvkk') }}">{{ __('KVKK AYDINLATMA METNİ') }}</a>
                </div>
                <a href="#" class="back-to-top">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
                </a>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchTrigger = document.getElementById('searchTrigger');
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const searchClose = document.getElementById('searchClose');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const navMenu = document.querySelector('.nav-menu');

            if (searchTrigger && searchForm) {
                searchTrigger.addEventListener('click', function() {
                    searchForm.style.visibility = 'visible';
                    searchForm.style.opacity = '1';
                    setTimeout(() => searchInput.focus(), 300);
                });

                if (searchClose) {
                    searchClose.addEventListener('click', function() {
                        searchForm.style.opacity = '0';
                        setTimeout(() => {
                            searchForm.style.visibility = 'hidden';
                        }, 300);
                    });
                }

                // Close on ESC
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        searchForm.style.opacity = '0';
                        setTimeout(() => {
                            searchForm.style.visibility = 'hidden';
                        }, 300);
                    }
                });
            }

            if (mobileMenuBtn && navMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
