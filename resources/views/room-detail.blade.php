<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail kamar {{ $roomType->name }} - Fasilitas lengkap dan harga terbaik hanya di Hotelku.">
    <title>{{ $roomType->name }} - Detail Kamar | Hotelku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0a1628;
            --navy-light: #132240;
            --navy-medium: #1a3050;
            --accent-gold: #c9a84c;
            --accent-gold-light: #e4cc7a;
            --accent-blue: #4a7cff;
            --accent-blue-glow: rgba(74, 124, 255, 0.25);
            --warm-white: #faf9f6;
            --text-secondary: #a0a8b8;
            --success-green: #34c77b;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--warm-white);
            color: #333;
        }

        /* Navbar */
        .navbar-premium {
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(20px);
            padding: 14px 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }
        .navbar-premium .navbar-brand {
            font-size: 24px; font-weight: 800; color: white !important;
        }
        .navbar-premium .navbar-brand i { color: var(--accent-gold); }
        .navbar-premium .nav-link {
            color: rgba(255,255,255,0.7) !important; font-weight: 500; font-size: 15px;
            padding: 8px 16px !important; border-radius: 8px; transition: var(--transition);
        }
        .navbar-premium .nav-link:hover {
            color: white !important; background: rgba(255,255,255,0.1);
        }

        /* Room Hero */
        .room-hero {
            padding: 40px 0 60px;
            background: white;
        }
        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--text-secondary); text-decoration: none;
            font-weight: 500; font-size: 14px; margin-bottom: 30px;
            transition: var(--transition); padding: 8px 0;
        }
        .back-link:hover { color: var(--accent-blue); }
        .back-link i { transition: transform 0.3s; }
        .back-link:hover i { transform: translateX(-4px); }

        .room-image {
            height: 480px; object-fit: cover;
            border-radius: var(--radius-lg);
            width: 100%;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .recommend-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(201, 168, 76, 0.12);
            border: 1px solid rgba(201, 168, 76, 0.25);
            color: var(--accent-gold);
            padding: 8px 18px; border-radius: 50px;
            font-size: 13px; font-weight: 700;
            letter-spacing: 0.5px; margin-bottom: 16px;
        }

        .room-name {
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 800; color: var(--navy);
            letter-spacing: -0.5px; margin-bottom: 8px;
        }
        .room-location {
            font-size: 16px; color: var(--text-secondary);
            margin-bottom: 28px; display: flex; align-items: center; gap: 8px;
        }
        .room-location i { color: var(--accent-blue); }

        .price-card {
            background: linear-gradient(135deg, var(--navy), var(--navy-medium));
            border-radius: var(--radius-lg);
            padding: 28px 32px; color: white; margin-bottom: 28px;
        }
        .price-card .price-label {
            font-size: 13px; color: rgba(255,255,255,0.5);
            font-weight: 500; margin-bottom: 4px;
        }
        .price-card .price-value {
            font-size: 32px; font-weight: 800;
        }
        .price-card .price-unit {
            font-size: 16px; font-weight: 400; color: rgba(255,255,255,0.6);
        }

        .room-description {
            font-size: 16px; color: #5a6577;
            line-height: 1.8; margin-bottom: 28px;
        }

        .btn-book-now {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            color: var(--navy); border: none;
            padding: 18px 32px; border-radius: var(--radius-sm);
            font-weight: 700; font-size: 17px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 8px 25px rgba(201, 168, 76, 0.35);
        }
        .btn-book-now:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 35px rgba(201, 168, 76, 0.45);
            color: var(--navy);
        }

        .availability-info {
            text-align: center; margin-top: 14px;
            font-size: 14px; font-weight: 500;
        }
        .availability-info.available { color: var(--success-green); }
        .availability-info.unavailable { color: #ef4444; }

        /* Feature */
        .features-section { padding: 60px 0 80px; }
        .features-title {
            font-size: 1.6rem; font-weight: 800; color: var(--navy);
            margin-bottom: 32px; letter-spacing: -0.3px;
        }

        .feature-card {
            background: white; border-radius: var(--radius-lg);
            padding: 32px 24px; text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: var(--transition); height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 64px; height: 64px; border-radius: 16px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 16px;
            background: rgba(74, 124, 255, 0.1); color: var(--accent-blue);
            transition: var(--transition);
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(-5deg);
            background: var(--accent-blue); color: white;
        }

        .feature-card h6 {
            font-weight: 700; font-size: 16px; color: var(--navy); margin-bottom: 6px;
        }
        .feature-card p {
            font-size: 13px; color: var(--text-secondary); line-height: 1.6;
        }

        /* Footer */
        .footer-mini {
            background: linear-gradient(180deg, var(--navy) 0%, #060e1a 100%);
            padding: 30px 0; text-align: center;
            font-size: 14px; color: rgba(255,255,255,0.5);
        }
        .footer-mini i { color: var(--accent-gold); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-premium sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/"><i class="fa-solid fa-arrow-left me-1"></i> Beranda</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="room-hero">
    <div class="container">
        <a href="/" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>

        <div class="row align-items-center g-5">
            <div class="col-lg-7" data-aos="fade-right" data-aos-duration="800">
                <img src="{{ Str::startsWith($roomType->foto_url, 'http') ? $roomType->foto_url : asset('storage/' . $roomType->foto_url) }}" class="room-image" alt="{{ $roomType->name }}">
            </div>
            <div class="col-lg-5" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <div class="recommend-badge">
                    <i class="fa-solid fa-star"></i> Highly Recommended
                </div>
                <h1 class="room-name">{{ $roomType->name }}</h1>
                <div class="room-location">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $roomType->location ?? 'Lokasi Utama' }}
                </div>

                <div class="price-card">
                    <span class="price-label">Harga Per Malam</span>
                    <div>
                        <span class="price-value">Rp {{ number_format($roomType->price, 0, ',', '.') }}</span>
                        <span class="price-unit">/ malam</span>
                    </div>
                </div>

                <p class="room-description">{{ $roomType->description ?? 'Nikmati kenyamanan beristirahat di ruangan pilihan kami yang didesain secara khusus untuk memenuhi segala kebutuhan eksklusif Anda selama menginap.' }}</p>

                <a href="{{ route('booking.form', $roomType->id) }}" class="btn-book-now">
                    <i class="fa-solid fa-calendar-check"></i> Pesan Kamar Sekarang
                </a>

                <div class="availability-info {{ $availableRooms > 0 ? 'available' : 'unavailable' }}">
                    @if($availableRooms > 0)
                        <i class="fa-solid fa-circle-check me-1"></i>Tersedia <b>{{ $availableRooms }}</b> kamar kosong hari ini!
                    @else
                        <i class="fa-solid fa-circle-xmark me-1"></i>Stok untuk hari ini penuh / Silakan atur tanggal esok pada form pemesanan
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <h3 class="features-title" data-aos="fade-up"><i class="fa-solid fa-sparkles me-2" style="color: var(--accent-gold);"></i>Fasilitas Utama</h3>
        <div class="row g-4">
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-wifi"></i></div>
                    <h6>Free Wi-Fi</h6>
                    <p>Kecepatan hingga 100Mbps</p>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-tv"></i></div>
                    <h6>Smart TV 43"</h6>
                    <p>Dilengkapi Netflix & YouTube</p>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-shower"></i></div>
                    <h6>Water Heater</h6>
                    <p>Kamar mandi dalam khusus</p>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-mug-hot"></i></div>
                    <h6>Breakfast</h6>
                    <p>Sarapan Pagi Eksklusif</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-mini">
    <div class="container">
        &copy; {{ date('Y') }} Hotelku. Crafted with <i class="fa-solid fa-heart"></i> for Premium Hospitality.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });</script>
</body>
</html>
