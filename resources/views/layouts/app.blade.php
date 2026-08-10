<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ config('app.supported_locales.'.app()->getLocale().'.dir', 'ltr') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteSettings['site_name'] ?? 'LandMark Realty') — @yield('title_suffix', $siteSettings['site_tagline'] ?? 'Your Trusted Real Estate Partner')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['seo_meta_description'] ?? 'Find land, flats, houses and commercial properties for sale and rent across Bangladesh.')">
    {{-- SEO: declared language + alternate locale signals --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'bn' ? 'bn_BD' : 'en_US' }}">
    @foreach(array_keys(config('app.supported_locales', [])) as $loc)
        @if($loc !== app()->getLocale())
    <meta property="og:locale:alternate" content="{{ $loc === 'bn' ? 'bn_BD' : 'en_US' }}">
        @endif
    @endforeach
    @if(!empty($siteSettings['seo_meta_keywords']))
    <meta name="keywords" content="{{ $siteSettings['seo_meta_keywords'] }}">
    @endif
    @if(!empty($siteSettings['site_favicon']))
    <link rel="icon" href="{{ asset($siteSettings['site_favicon']) }}" type="image/x-icon">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- GLightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
        :root {
            --primary: #1a2b4a;
            --primary-dark: #0f1d33;
            --accent: #b8962e;
            --accent-light: #d4af55;
            --bg: #f8f6f1;
            --white: #ffffff;
            --text: #2d3748;
            --text-muted: #718096;
            --border: #e2d9c8;
            --card-shadow: 0 4px 24px rgba(26,43,74,0.08);
            --card-shadow-hover: 0 8px 40px rgba(26,43,74,0.16);
            --radius: 10px;
            --radius-lg: 16px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
        }

        /* Navbar */
        .navbar-brand-logo {
            display: flex;
            align-items: center;
        }

        .navbar-brand-logo img {
            height: 48px;
            width: auto;
            object-fit: contain;
        }

        @media (max-width: 576px) {
            .navbar-brand-logo img { height: 38px; }
        }

        .navbar-main {
            background: var(--primary) !important;
            padding: 1rem 0;
            box-shadow: 0 2px 16px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .navbar-main.scrolled {
            padding: 0.6rem 0;
            box-shadow: 0 2px 24px rgba(0,0,0,0.25);
        }

        .navbar-main .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            padding: 0.5rem 1rem !important;
            transition: color 0.2s;
        }

        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active { color: var(--accent-light) !important; }

        .btn-accent {
            background: var(--accent);
            color: #fff;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
        }

        .btn-accent:hover {
            background: var(--accent-light);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(184,150,46,0.4);
        }

        .btn-outline-accent {
            border: 2px solid var(--accent);
            color: var(--accent);
            font-weight: 600;
            background: transparent;
        }

        .btn-outline-accent:hover {
            background: var(--accent);
            color: #fff;
        }

        /* Section titles */
        .section-title {
            font-size: 2.4rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: 1.05rem;
            margin-bottom: 3rem;
        }

        .gold-line {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            border-radius: 2px;
            margin: 0.8rem auto 1.2rem;
        }

        /* Property Card */
        .property-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid var(--border);
        }

        .property-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-shadow-hover);
        }

        .property-card .card-img-wrapper {
            position: relative;
            overflow: hidden;
            /* height: 220px; */
        }

        .property-card .card-img-wrapper img {
            width: 100%;
            height: 100%;
            /* object-fit: cover; */
            transition: transform 0.5s ease;
        }

        .property-card:hover .card-img-wrapper img { transform: scale(1.07); }

        .property-card .badge-status {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .badge-sale { background: var(--primary); color: #fff; }
        .badge-rent { background: var(--accent); color: #fff; }
        .badge-featured { background: linear-gradient(135deg, var(--accent), var(--accent-light)); color: #fff; }

        .property-card .card-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
        }

        /* Currency symbol — Bengali-capable font so ৳ renders crisply and
           consistently across every price on the site (cards, detail, etc.) */
        .taka {
            font-family: 'Hind Siliguri', 'Inter', sans-serif;
            font-weight: 600;
            margin-right: 1px;
        }

        .property-card .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            line-clamp: 2;
        }

        .property-card .card-title:hover { color: var(--accent); }

        .prop-meta { font-size: 0.82rem; color: var(--text-muted); }
        .prop-meta i { color: var(--accent); margin-right: 3px; }

        /* Footer */
        .footer-main {
            background: var(--primary-dark);
            color: rgba(255,255,255,0.8);
            padding: 4rem 0 2rem;
        }

        .footer-main h5 {
            color: var(--accent-light);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .footer-main a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .footer-main a:hover { color: var(--accent-light); }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: #fff !important;
            margin-right: 8px;
            transition: all 0.2s;
        }

        .footer-social a:hover { background: var(--accent); }

        /* Alerts */
        .alert-success-custom {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: var(--radius);
        }

        /* Smooth page transitions */
        .page-fade { animation: fadeInUp 0.5s ease; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Loading spinner */
        .spinner-overlay {
            position: fixed; inset: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }

        /* Back to top */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 44px;
            height: 44px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
            box-shadow: 0 4px 16px rgba(184,150,46,0.4);
            cursor: pointer;
            transition: all 0.3s;
        }

        #backToTop:hover { background: var(--accent-light); transform: translateY(-2px); }
        #backToTop.visible { display: flex; }

        /* Form controls */
        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(184,150,46,0.15);
            outline: none;
        }

        /* Toast notifications */
        .toast-container { z-index: 11000; }

        @media (max-width: 768px) {
            .section-title { font-size: 1.8rem; }
            /* .property-card .card-img-wrapper { height: 180px; } */
        }

        /* Language switcher */
        .lang-switcher .dropdown-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            color: rgba(255,255,255,0.85) !important;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 20px;
            padding: 0.3rem 0.85rem !important;
            transition: all 0.2s;
        }
        .lang-switcher .dropdown-toggle:hover { color: #fff !important; border-color: var(--accent-light); }
        .lang-switcher .dropdown-toggle::after { margin-left: 0.1rem; }
        .lang-switcher .dropdown-menu { min-width: 9rem; border: none; box-shadow: var(--card-shadow); }
        .lang-switcher .dropdown-item { font-size: 0.88rem; display: flex; align-items: center; gap: 0.5rem; }
        .lang-switcher .dropdown-item.active { background: var(--accent); color: #fff; }
        .lang-flag { font-size: 1.05rem; line-height: 1; }

        /* Bengali typography — Cormorant Garamond has no Bengali glyphs, so when
           the site is in Bangla we switch the display + body faces to a
           Bengali-capable font for crisp, consistent rendering. */
        html[lang="bn"] body,
        html[lang="bn"] h1, html[lang="bn"] h2, html[lang="bn"] h3,
        html[lang="bn"] h4, html[lang="bn"] h5, html[lang="bn"] h6,
        html[lang="bn"] .hero-title, html[lang="bn"] .section-title,
        html[lang="bn"] .card-title, html[lang="bn"] .card-price,
        html[lang="bn"] .stat-number, html[lang="bn"] .price-main {
            font-family: 'Hind Siliguri', 'Inter', sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg sticky-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand navbar-brand-logo" href="{{ route('home') }}">
            <img src="{{ !empty($siteSettings['site_logo']) ? asset($siteSettings['site_logo']) : asset('logo.jpeg') }}"
                 alt="{{ $siteSettings['site_name'] ?? 'LandMark Realty' }}"
                 onerror="this.onerror=null;this.src='{{ asset('logo.jpeg') }}'">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('messages.nav.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}" href="{{ route('properties.index') }}">{{ __('messages.nav.properties') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ __('messages.nav.about') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('messages.nav.contact') }}</a>
                </li>
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isAgent())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>{{ __('messages.nav.admin') }}</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>{{ __('messages.nav.logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">{{ __('messages.nav.login') }}</a>
                    </li>
                @endauth

                {{-- Language Switcher --}}
                @php($currentLocale = app()->getLocale())
                @php($currentLang = config('app.supported_locales.'.$currentLocale))
                <li class="nav-item dropdown lang-switcher ms-lg-2 mt-2 mt-lg-0">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false" aria-label="{{ __('messages.nav.language') }}">
                        <span class="lang-flag">{{ $currentLang['flag'] ?? '🌐' }}</span>
                        <span>{{ $currentLang['native'] ?? strtoupper($currentLocale) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach(config('app.supported_locales', []) as $code => $lang)
                        <li>
                            <a class="dropdown-item {{ $code === $currentLocale ? 'active' : '' }}"
                               href="{{ route('locale.switch', $code) }}" hreflang="{{ $code }}">
                                <span class="lang-flag">{{ $lang['flag'] }}</span>
                                <span>{{ $lang['native'] }}</span>
                                @if($code === $currentLocale)<i class="bi bi-check2 ms-auto"></i>@endif
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Flash messages -->
@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<!-- Page Content -->
<main class="page-fade">
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer-main mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                @if(!empty($siteSettings['site_logo']))
                <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'LandMark Realty' }}" style="height:44px;object-fit:contain;margin-bottom:0.75rem;">
                @else
                <h5 style="font-size:1.6rem;">{{ $siteSettings['site_name'] ?? 'LandMark' }} <span style="color:#fff;font-weight:400;"> Realty</span></h5>
                @endif
                <p style="font-size:0.88rem;line-height:1.8;">{{ $siteSettings['site_tagline'] ?? 'Your most trusted real estate partner in Bangladesh.' }}</p>
                <div class="footer-social mt-3">
                    @if(!empty($siteSettings['social_facebook']))
                    <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if(!empty($siteSettings['social_instagram']))
                    <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if(!empty($siteSettings['social_youtube']))
                    <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if(!empty($siteSettings['company_whatsapp']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['company_whatsapp']) }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    @endif
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <h5>{{ __('messages.footer.quick_links') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('properties.index') }}?listing_type=sale">{{ __('messages.footer.buy_property') }}</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index') }}?listing_type=rent">{{ __('messages.footer.rent_property') }}</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index') }}?type=land">{{ __('messages.types.land') }}</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index') }}?type=flat">{{ __('messages.types.flats') }}</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}">{{ __('messages.nav.about') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-sm-6">
                <h5>{{ __('messages.footer.property_types') }}</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('properties.index') }}?type=house">{{ __('messages.types.houses') }}</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index') }}?type=commercial">{{ __('messages.types.commercial') }}</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index') }}?division=Dhaka">Dhaka</a></li>
                    <li class="mb-2"><a href="{{ route('properties.index') }}?division=Chittagong">Chittagong</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}">{{ __('messages.nav.contact') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5>{{ __('messages.common.contact_us') }}</h5>
                <ul class="list-unstyled" style="font-size:0.88rem;">
                    @if(!empty($siteSettings['company_address']))
                    <li class="mb-2"><i class="bi bi-geo-alt-fill me-2" style="color:var(--accent-light);"></i>{{ $siteSettings['company_address'] }}</li>
                    @endif
                    @if(!empty($siteSettings['company_phone']))
                    <li class="mb-2"><i class="bi bi-telephone-fill me-2" style="color:var(--accent-light);"></i><a href="tel:{{ preg_replace('/\s+/', '', $siteSettings['company_phone']) }}">{{ $siteSettings['company_phone'] }}</a></li>
                    @endif
                    @if(!empty($siteSettings['company_email']))
                    <li class="mb-2"><i class="bi bi-envelope-fill me-2" style="color:var(--accent-light);"></i><a href="mailto:{{ $siteSettings['company_email'] }}">{{ $siteSettings['company_email'] }}</a></li>
                    @endif
                    @if(!empty($siteSettings['company_hours']))
                    <li class="mb-2"><i class="bi bi-clock-fill me-2" style="color:var(--accent-light);"></i>{{ $siteSettings['company_hours'] }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <hr style="border-color:rgba(255,255,255,0.1);margin:2rem 0 1.5rem;">
        <div class="d-flex flex-wrap justify-content-between align-items-center" style="font-size:0.82rem;color:rgba(255,255,255,0.5);">
            <span>© {{ date('Y') }} {{ $siteSettings['copyright_text'] ?? 'LandMark Realty. All rights reserved.' }}</span>
            <span>{{ __('messages.footer.tagline') }}</span>
        </div>
    </div>
</footer>

<!-- Back to top button -->
<button id="backToTop" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

<!-- Toast container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer"></div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Navbar scroll effect
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 50) {
            $('#mainNav').addClass('scrolled');
            $('#backToTop').addClass('visible');
        } else {
            $('#mainNav').removeClass('scrolled');
            $('#backToTop').removeClass('visible');
        }
    });

    // Back to top
    $('#backToTop').on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 600);
    });

    // AJAX setup — attach CSRF token to all jQuery AJAX requests
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Toast helper
    function showToast(message, type = 'success') {
        const id = 'toast_' + Date.now();
        const icon = type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill';
        const color = type === 'success' ? 'success' : 'danger';
        const html = `<div id="${id}" class="toast align-items-center text-bg-${color} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-${icon} me-2"></i>${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>`;
        $('#toastContainer').append(html);
        const toast = new bootstrap.Toast(document.getElementById(id), { delay: 5000 });
        toast.show();
        document.getElementById(id).addEventListener('hidden.bs.toast', () => $(`#${id}`).remove());
    }
</script>

@stack('scripts')

@if(!empty($siteSettings['seo_google_analytics']))
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['seo_google_analytics'] }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $siteSettings['seo_google_analytics'] }}');
</script>
@endif
</body>
</html>
