<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hotelku - Platform reservasi hotel premium dengan harga terbaik. Pesan kamar, nikmati restoran, dan rasakan pengalaman menginap luar biasa.">
    <title>Hotelku - Pesan Kamar & Pengalaman Menginap Terbaik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           DESIGN SYSTEM — Hotelku Theme
        ═══════════════════════════════════════════ */
        :root {
            --navy: #0a1628;
            --navy-light: #132240;
            --navy-medium: #1a3050;
            --accent-gold: #c9a84c;
            --accent-gold-light: #e4cc7a;
            --accent-blue: #4a7cff;
            --accent-blue-glow: rgba(74, 124, 255, 0.25);
            --warm-white: #faf9f6;
            --text-primary: #e8e6e1;
            --text-secondary: #a0a8b8;
            --glass-bg: rgba(255, 255, 255, 0.06);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-bg-light: rgba(255, 255, 255, 0.92);
            --success-green: #34c77b;
            --price-accent: #ff8c42;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.12);
            --shadow-glow: 0 0 30px rgba(74, 124, 255, 0.15);
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--warm-white);
            color: #333;
            overflow-x: hidden;
        }

        /* ═══════════════ NAVBAR ═══════════════ */
        .navbar-premium {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 18px 0;
            transition: var(--transition);
            background: transparent;
        }

        .navbar-premium.scrolled {
            background: rgba(10, 22, 40, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            padding: 10px 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .navbar-premium .navbar-brand {
            font-size: 26px;
            font-weight: 800;
            color: white !important;
            letter-spacing: -0.5px;
        }
        .navbar-premium .navbar-brand i {
            color: var(--accent-gold);
            transition: transform 0.3s;
        }
        .navbar-premium .navbar-brand:hover i {
            transform: rotate(-10deg) scale(1.1);
        }

        .navbar-premium .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            padding: 8px 18px !important;
            border-radius: 8px;
            transition: var(--transition);
            font-size: 15px;
        }
        .navbar-premium .nav-link:hover {
            color: white !important;
            background: rgba(255,255,255,0.1);
        }

        .btn-nav-login {
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            color: var(--navy) !important;
            font-weight: 700;
            padding: 10px 28px !important;
            border-radius: 50px;
            border: none;
            transition: var(--transition);
            text-decoration: none;
            font-size: 14px;
        }
        .btn-nav-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(201, 168, 76, 0.4);
            color: var(--navy) !important;
        }

        .btn-nav-outline {
            color: var(--accent-gold) !important;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 20px !important;
            border: 1.5px solid rgba(201, 168, 76, 0.4);
            border-radius: 50px;
            transition: var(--transition);
            font-size: 14px;
        }
        .btn-nav-outline:hover {
            background: rgba(201, 168, 76, 0.1);
            border-color: var(--accent-gold);
            color: var(--accent-gold-light) !important;
        }

        /* ═══════════════ HERO SECTION ═══════════════ */
        .hero-premium {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('{{ asset("images/hero-hotel.png") }}') center/cover no-repeat;
            transform: scale(1.05);
            animation: heroZoom 20s ease-in-out infinite alternate;
        }

        @keyframes heroZoom {
            0% { transform: scale(1.05); }
            100% { transform: scale(1.12); }
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(10, 22, 40, 0.5) 0%,
                rgba(10, 22, 40, 0.65) 50%,
                rgba(10, 22, 40, 0.92) 100%
            );
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(201, 168, 76, 0.15);
            border: 1px solid rgba(201, 168, 76, 0.3);
            color: var(--accent-gold-light);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }

        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            color: rgba(255,255,255,0.7);
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        /* ═══════════════ FLOATING SEARCH ═══════════════ */
        .search-floating {
            position: relative;
            z-index: 10;
            margin-top: -65px;
        }

        .search-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 30px 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .search-card label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .search-card .form-control,
        .search-card .form-select {
            border: 2px solid #eef0f5;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-weight: 500;
            font-size: 15px;
            transition: var(--transition);
            background: #f8f9fc;
        }

        .search-card .form-control:focus,
        .search-card .form-select:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 4px var(--accent-blue-glow);
            background: white;
        }

        .search-card .input-group-text {
            background: #f8f9fc;
            border: 2px solid #eef0f5;
            border-right: none;
            color: var(--accent-blue);
            font-size: 16px;
        }

        .btn-search-main {
            background: linear-gradient(135deg, var(--accent-blue), #3562e3);
            color: white;
            font-weight: 700;
            font-size: 16px;
            padding: 14px 32px;
            border: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            width: 100%;
            height: 100%;
            min-height: 52px;
        }
        .btn-search-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(74, 124, 255, 0.35);
            color: white;
        }

        /* ═══════════════ TRUST BADGES ═══════════════ */
        .trust-section { padding: 80px 0 40px; }

        .trust-item {
            text-align: center;
            padding: 30px 20px;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }
        .trust-item:hover {
            background: white;
            box-shadow: var(--shadow-card);
            transform: translateY(-4px);
        }

        .trust-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
            transition: var(--transition);
        }

        .trust-item:hover .trust-icon { transform: scale(1.1) rotate(-5deg); }

        .trust-icon.blue { background: rgba(74, 124, 255, 0.1); color: var(--accent-blue); }
        .trust-icon.gold { background: rgba(201, 168, 76, 0.1); color: var(--accent-gold); }
        .trust-icon.green { background: rgba(52, 199, 123, 0.1); color: var(--success-green); }

        .trust-item h6 { font-weight: 700; font-size: 16px; color: var(--navy); margin-bottom: 6px; }
        .trust-item p { color: var(--text-secondary); font-size: 14px; line-height: 1.6; }

        /* ═══════════════ SECTION HEADERS ═══════════════ */
        .section-header {
            margin-bottom: 48px;
        }
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent-gold);
            margin-bottom: 12px;
        }
        .section-label::before {
            content: '';
            width: 30px;
            height: 2px;
            background: var(--accent-gold);
            border-radius: 2px;
        }
        .section-title-main {
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }
        .section-subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            max-width: 500px;
        }

        /* ═══════════════ HOTEL CARDS ═══════════════ */
        .hotels-section {
            padding: 80px 0;
            background: white;
        }

        .hotel-card {
            border: none;
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: var(--transition);
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .hotel-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .hotel-card .card-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 240px;
        }

        .hotel-card .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .hotel-card:hover .card-img-wrapper img {
            transform: scale(1.08);
        }

        .hotel-card .card-img-overlay-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            display: flex;
            gap: 8px;
        }

        .badge-glass {
            background: rgba(10, 22, 40, 0.7);
            backdrop-filter: blur(10px);
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .badge-rating {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(201, 168, 76, 0.9);
            backdrop-filter: blur(10px);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .hotel-card .card-body {
            padding: 24px;
        }

        .hotel-card .card-title {
            font-weight: 700;
            font-size: 20px;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .hotel-card .location-text {
            color: var(--text-secondary);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 16px;
        }
        .hotel-card .location-text i { color: var(--accent-blue); }

        .hotel-card .facilities {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .facility-tag {
            background: #f0f4ff;
            color: var(--accent-blue);
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .hotel-card .card-footer-custom {
            border-top: 1px solid #f0f1f5;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .price-from { font-size: 12px; color: var(--text-secondary); font-weight: 500; }
        .price-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--success-green);
            line-height: 1;
        }

        .btn-select-room {
            background: linear-gradient(135deg, var(--navy), var(--navy-medium));
            color: white;
            padding: 12px 24px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            border: none;
        }
        .btn-select-room:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(10, 22, 40, 0.3);
            color: white;
        }
        .btn-select-room i { transition: transform 0.3s; }
        .btn-select-room:hover i { transform: translateX(4px); }

        /* ═══════════════ RESTAURANT SECTION ═══════════════ */
        .restaurant-section {
            padding: 80px 0;
            background: var(--warm-white);
        }

        .menu-card {
            border: none;
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: var(--transition);
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.1);
        }

        .menu-card .menu-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 180px;
        }

        .menu-card .menu-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .menu-card:hover .menu-img-wrapper img {
            transform: scale(1.06);
        }

        .menu-card .card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .menu-card h6 {
            font-weight: 700;
            font-size: 16px;
            color: var(--navy);
            margin-bottom: 6px;
        }
        .menu-card .menu-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 16px;
            flex-grow: 1;
        }

        .menu-card .menu-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-price {
            font-size: 18px;
            font-weight: 800;
            color: var(--price-accent);
        }

        .btn-order-menu {
            background: transparent;
            color: var(--navy);
            border: 2px solid var(--navy);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }
        .btn-order-menu:hover {
            background: var(--navy);
            color: white;
            transform: translateY(-2px);
        }

        /* ═══════════════ FOOTER ═══════════════ */
        .footer-premium {
            background: linear-gradient(180deg, var(--navy) 0%, #060e1a 100%);
            color: rgba(255,255,255,0.7);
            padding-top: 80px;
        }

        .footer-wave {
            position: relative;
            height: 60px;
            overflow: hidden;
            background: var(--warm-white);
        }
        .footer-wave::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--navy);
            clip-path: ellipse(70% 100% at 50% 100%);
        }

        .footer-brand {
            font-size: 28px;
            font-weight: 800;
            color: white;
            margin-bottom: 16px;
        }
        .footer-brand i { color: var(--accent-gold); }

        .footer-desc { font-size: 14px; line-height: 1.8; max-width: 320px; }

        .footer-heading {
            color: white;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 12px;
        }
        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent-gold);
            border-radius: 2px;
        }

        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .footer-links a::before {
            content: '';
            width: 0;
            height: 1px;
            background: var(--accent-gold);
            transition: width 0.3s;
        }
        .footer-links a:hover {
            color: var(--accent-gold-light);
        }
        .footer-links a:hover::before {
            width: 14px;
        }

        .footer-contact li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 14px;
        }
        .footer-contact i {
            color: var(--accent-gold);
            width: 18px;
            text-align: center;
        }

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        .footer-social a {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: var(--transition);
            font-size: 16px;
        }
        .footer-social a:hover {
            background: var(--accent-gold);
            border-color: var(--accent-gold);
            color: var(--navy);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 24px 0;
            margin-top: 50px;
            text-align: center;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
        }

        /* ═══════════════ MISC / UTILITIES ═══════════════ */
        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.2);
            padding: 6px 10px;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Scroll-to-top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            color: var(--navy);
            border: none;
            border-radius: 14px;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: var(--transition);
            z-index: 999;
            box-shadow: 0 6px 20px rgba(201, 168, 76, 0.4);
        }
        .scroll-top:hover { transform: translateY(-4px); }
        .scroll-top.visible { display: flex; }

        /* Responsive */
        @media (max-width: 991px) {
            .navbar-premium .navbar-collapse {
                background: rgba(10, 22, 40, 0.95);
                backdrop-filter: blur(20px);
                border-radius: var(--radius-md);
                padding: 20px;
                margin-top: 10px;
            }
        }
        @media (max-width: 767px) {
            .search-card { padding: 20px; }
            .hero-premium { min-height: 90vh; }
        }
    </style>
</head>
<body>

    <!-- ═══ NAVBAR ═══ -->
    <nav class="navbar navbar-expand-lg navbar-premium" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#hotel">Akomodasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#restoran">Restoran</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        @if(Auth::user()->role === 'user')
                            <a href="/dashboard" class="btn-nav-login">
                                <i class="fa-solid fa-list-check me-2"></i>Pesanan Saya
                            </a>
                            <a href="/dashboard" onclick="event.preventDefault(); localStorage.setItem('activeDashboardTab', '#tab-profile'); window.location.href='/dashboard';" class="btn-nav-outline" style="padding: 10px 14px !important;" title="Profil Saya">
                                <i class="fa-solid fa-user"></i>
                            </a>
                        @else
                            <a href="/dashboard" class="btn-nav-login">
                                <i class="fa-solid fa-gauge-high me-2"></i>Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn-nav-outline">Daftar</a>
                        <a href="{{ route('login') }}" class="btn-nav-login">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ═══ HERO ═══ -->
    <header class="hero-premium">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
            <div class="hero-badge">
                <i class="fa-solid fa-gem"></i>
                Premium Hospitality Experience
            </div>
            <h1 class="hero-title">
                Temukan Pengalaman<br>
                Menginap <span class="highlight">Luar Biasa</span>
            </h1>
            <p class="hero-subtitle">
                Pesan langsung dari website kami untuk harga terbaik, tanpa biaya tersembunyi. Nikmati pelayanan bintang lima dari kamar pilihan Anda.
            </p>
            <a href="#hotel" class="btn-search-main" style="display: inline-flex; align-items: center; gap: 10px; width: auto; padding: 16px 40px; border-radius: 50px; font-size: 16px;">
                <i class="fa-solid fa-magnifying-glass"></i>Jelajahi Kamar
            </a>
        </div>
    </header>

    <!-- ═══ FLOATING SEARCH WIDGET ═══ -->
    <div class="container search-floating" data-aos="fade-up" data-aos-delay="200">
        <div class="search-card">
            <form action="{{ url('/search') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label>Lokasi Hotel</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                            <select name="location" class="form-select">
                                <option value="">Semua Lokasi</option>
                                @foreach($hotels->pluck('location')->unique() as $loc)
                                    <option value="{{ $loc }}">{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label>Tanggal Check-in</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-regular fa-calendar"></i></span>
                            <input type="date" name="check_in" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label>Tanggal Check-out</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-regular fa-calendar-check"></i></span>
                            <input type="date" name="check_out" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <button type="submit" class="btn-search-main">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>Cari Kamar Kosong
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ═══ TRUST BADGES ═══ -->
    <section class="trust-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="trust-item">
                        <div class="trust-icon blue"><i class="fa-solid fa-shield-halved"></i></div>
                        <h6>Pemesanan Aman & Terenkripsi</h6>
                        <p>Data pribadi Anda dilindungi dengan enkripsi tingkat enterprise dan standar keamanan internasional.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="trust-item">
                        <div class="trust-icon gold"><i class="fa-solid fa-tag"></i></div>
                        <h6>Jaminan Harga Terbaik</h6>
                        <p>Tidak ada biaya tersembunyi. Harga transparan dan dijamin paling kompetitif saat pemesanan langsung.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="trust-item">
                        <div class="trust-icon green"><i class="fa-solid fa-headset"></i></div>
                        <h6>Layanan Pelanggan 24/7</h6>
                        <p>Tim resepsionis profesional kami siap membantu Anda kapan saja, sepanjang hari tanpa batas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ HOTEL DESTINATIONS ═══ -->
    <section id="hotel" class="hotels-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-label">Destinasi Kami</div>
                <h2 class="section-title-main">Pilihan Hotel Premium</h2>
                <p class="section-subtitle">Jelajahi lokasi hotel kami dan temukan kamar yang sempurna untuk perjalanan Anda.</p>
            </div>

            <div class="row g-4">
                @foreach($hotels as $hotel)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card hotel-card h-100">
                        <div class="card-img-wrapper">
                            <img src="{{ Str::startsWith($hotel->foto_url, 'http') ? $hotel->foto_url : asset('storage/' . $hotel->foto_url) }}" alt="{{ $hotel->name }}">
                            <div class="card-img-overlay-badge">
                                <span class="badge-glass"><i class="fa-solid fa-building me-1"></i>{{ $hotel->room_count }} Tipe</span>
                            </div>
                            <span class="badge-rating"><i class="fa-solid fa-star me-1"></i>5.0</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $hotel->name }}</h5>
                            <div class="location-text">
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $hotel->location }}
                            </div>
                            <div class="facilities">
                                <span class="facility-tag"><i class="fa-solid fa-wifi me-1"></i>Wi-Fi</span>
                                <span class="facility-tag"><i class="fa-solid fa-water-ladder me-1"></i>Pool</span>
                                <span class="facility-tag"><i class="fa-solid fa-utensils me-1"></i>Resto</span>
                            </div>
                            <div class="card-footer-custom">
                                <div>
                                    <span class="price-from">Mulai Dari</span>
                                    <div class="price-value">Rp {{ number_format($hotel->min_price, 0, ',', '.') }}</div>
                                </div>
                                <a href="{{ route('hotel.detail', urlencode($hotel->location)) }}" class="btn-select-room">
                                    Pilih Kamar <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ═══ FACILITIES GALLERY ═══ -->
    <section class="facilities-gallery py-5" style="background: linear-gradient(180deg, white 0%, var(--warm-white) 100%);">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <div class="section-label" style="justify-content: center;">Fasilitas</div>
                <h2 class="section-title-main">Kemewahan di Setiap Sudut</h2>
                <p class="section-subtitle" style="margin: 0 auto;">Nikmati fasilitas kelas dunia untuk pengalaman menginap yang tak terlupakan.</p>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="0">
                    <div style="position:relative; border-radius: var(--radius-lg); overflow:hidden; height: 340px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <img src="{{ asset('images/pool-facility.png') }}" alt="Infinity Pool" style="width:100%; height:100%; object-fit:cover; transition: transform 0.6s ease;">
                        <div style="position:absolute; inset:0; background: linear-gradient(transparent 40%, rgba(10,22,40,0.8)); display:flex; align-items:flex-end; padding:28px;">
                            <div>
                                <h5 style="color:white; font-weight:700; margin-bottom:4px;"><i class="fa-solid fa-water-ladder me-2" style="color:var(--accent-gold);"></i>Infinity Pool</h5>
                                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin:0;">Kolam renang tepi pantai dengan pemandangan matahari terbenam spektakuler.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                    <div style="position:relative; border-radius: var(--radius-lg); overflow:hidden; height: 340px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <img src="{{ asset('images/restaurant-bg.png') }}" alt="Fine Dining Restaurant" style="width:100%; height:100%; object-fit:cover; transition: transform 0.6s ease;">
                        <div style="position:absolute; inset:0; background: linear-gradient(transparent 40%, rgba(10,22,40,0.8)); display:flex; align-items:flex-end; padding:28px;">
                            <div>
                                <h5 style="color:white; font-weight:700; margin-bottom:4px;"><i class="fa-solid fa-utensils me-2" style="color:var(--accent-gold);"></i>Fine Dining Restaurant</h5>
                                <p style="color:rgba(255,255,255,0.7); font-size:14px; margin:0;">Sajian kuliner premium dengan chef bintang dari berbagai masakan dunia.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div style="position:relative; border-radius: var(--radius-lg); overflow:hidden; height: 260px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <img src="{{ asset('images/spa-facility.png') }}" alt="Spa & Wellness" style="width:100%; height:100%; object-fit:cover; transition: transform 0.6s ease;">
                        <div style="position:absolute; inset:0; background: linear-gradient(transparent 30%, rgba(10,22,40,0.8)); display:flex; align-items:flex-end; padding:24px;">
                            <div>
                                <h6 style="color:white; font-weight:700; margin-bottom:2px;"><i class="fa-solid fa-spa me-2" style="color:var(--accent-gold);"></i>Spa & Wellness</h6>
                                <p style="color:rgba(255,255,255,0.7); font-size:13px; margin:0;">Relaksasi tubuh dan pikiran Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div style="position:relative; border-radius: var(--radius-lg); overflow:hidden; height: 260px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <img src="{{ asset('images/room-suite.png') }}" alt="Premium Suite" style="width:100%; height:100%; object-fit:cover; transition: transform 0.6s ease;">
                        <div style="position:absolute; inset:0; background: linear-gradient(transparent 30%, rgba(10,22,40,0.8)); display:flex; align-items:flex-end; padding:24px;">
                            <div>
                                <h6 style="color:white; font-weight:700; margin-bottom:2px;"><i class="fa-solid fa-bed me-2" style="color:var(--accent-gold);"></i>Premium Suite</h6>
                                <p style="color:rgba(255,255,255,0.7); font-size:13px; margin:0;">Kamar mewah dengan city view.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div style="position:relative; border-radius: var(--radius-lg); overflow:hidden; height: 260px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                        <img src="{{ asset('images/hero-hotel.png') }}" alt="Modern Architecture" style="width:100%; height:100%; object-fit:cover; transition: transform 0.6s ease;">
                        <div style="position:absolute; inset:0; background: linear-gradient(transparent 30%, rgba(10,22,40,0.8)); display:flex; align-items:flex-end; padding:24px;">
                            <div>
                                <h6 style="color:white; font-weight:700; margin-bottom:2px;"><i class="fa-solid fa-building me-2" style="color:var(--accent-gold);"></i>Modern Architecture</h6>
                                <p style="color:rgba(255,255,255,0.7); font-size:13px; margin:0;">Desain arsitektur premium terkini.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ RESTAURANT SECTION ═══ -->
    <section id="restoran" class="restaurant-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-label">Kuliner</div>
                <h2 class="section-title-main">Restoran & Layanan Kamar</h2>
                <p class="section-subtitle">Pesan hidangan lezat favorit Anda langsung ke kamar dengan satu klik.</p>
            </div>

            <div class="row g-4">
                @foreach($menus as $menu)
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <div class="menu-card">
                        <div class="menu-img-wrapper">
                            <img src="{{ Str::startsWith($menu->foto_url, 'http') ? $menu->foto_url : asset('storage/' . $menu->foto_url) }}" alt="{{ $menu->name }}">
                        </div>
                        <div class="card-body">
                            <h6>{{ $menu->name }}</h6>
                            <p class="menu-desc">{{ $menu->description }}</p>
                            <div class="menu-footer">
                                <span class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <a href="/restaurant-order/{{ $menu->id }}" class="btn-order-menu">Pesan</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ═══ FOOTER ═══ -->
    <div class="footer-wave"></div>
    <footer id="kontak" class="footer-premium">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-4 mb-4" data-aos="fade-up">
                    <div class="footer-brand"><i class="fa-solid fa-hotel me-2"></i>Hotelku</div>
                    <p class="footer-desc">Platform reservasi hotel premium yang dirancang untuk kenyamanan maksimal. Jaminan harga terbaik untuk setiap pemesanan langsung.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h6 class="footer-heading">Tentang</h6>
                    <ul class="footer-links">
                        <li><a href="#">Profil Hotel</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h6 class="footer-heading">Layanan</h6>
                    <ul class="footer-links">
                        <li><a href="#">Bantuan & FAQ</a></li>
                        <li><a href="#">Cara Memesan</a></li>
                        <li><a href="#">Aturan Pembatalan</a></li>
                        <li><a href="#">Partner Bisnis</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <h6 class="footer-heading">Hubungi Kami</h6>
                    <ul class="footer-contact list-unstyled">
                        <li><i class="fa-solid fa-location-dot"></i> Jl. Pariwisata No. 123</li>
                        <li><i class="fa-solid fa-phone"></i> +62 800 1234 5678</li>
                        <li><i class="fa-solid fa-envelope"></i> cs@hotelku.com</li>
                        <li><i class="fa-solid fa-clock"></i> Resepsionis 24 Jam</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Hotelku. Copyright by Adib Rijalun. Crafted with <i class="fa-solid fa-heart" style="color: var(--accent-gold);"></i> for Premium Hospitality.
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <button class="scroll-top" id="scrollTopBtn" onclick="window.scrollTo({top:0, behavior:'smooth'})">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            duration: 700,
            easing: 'ease-out-cubic'
        });

        // Navbar scroll effect
        const navbar = document.getElementById('mainNavbar');
        const scrollTopBtn = document.getElementById('scrollTopBtn');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 80) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            if (window.scrollY > 500) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });
    </script>
</body>
</html>