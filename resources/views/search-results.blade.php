<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kamar hotel premium yang tersedia untuk tanggal pencarian Anda.">
    <title>Hasil Pencarian - Hotelku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            --price-accent: #ff8c42;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.12);
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

        /* Hero */
        .hero-detail {
            position: relative;
            height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }
        .hero-detail .hero-bg {
            position: absolute; inset: 0;
            background: url('{{ asset("images/hotel-detail-hero.png") }}') center/cover;
            transform: scale(1.05);
        }
        .hero-detail .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(10,22,40,0.5) 0%, rgba(10,22,40,0.85) 100%);
        }
        .hero-detail .hero-content {
            position: relative; z-index: 2;
        }

        .breadcrumb-custom {
            display: flex; align-items: center; gap: 8px;
            justify-content: center;
            margin-bottom: 16px; font-size: 14px;
        }
        .breadcrumb-custom a {
            color: var(--accent-gold-light); text-decoration: none;
            transition: var(--transition);
        }
        .breadcrumb-custom a:hover { color: white; }
        .breadcrumb-custom span { color: rgba(255,255,255,0.5); }

        .hero-detail h1 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800; letter-spacing: -0.5px; margin-bottom: 10px;
        }
        .hero-detail p {
            font-size: 16px; color: rgba(255,255,255,0.7); max-width: 500px; margin: 0 auto;
        }

        /* Section */
        .rooms-section { padding: 70px 0 80px; }
        .section-header { margin-bottom: 40px; }
        .section-label {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 13px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 2px; color: var(--accent-gold); margin-bottom: 12px;
        }
        .section-label::before {
            content: ''; width: 30px; height: 2px;
            background: var(--accent-gold); border-radius: 2px;
        }
        .section-title-main {
            font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800;
            color: var(--navy); letter-spacing: -0.5px; margin-bottom: 8px;
        }
        .section-subtitle { font-size: 15px; color: var(--text-secondary); }

        /* Room Card */
        .room-card {
            border: none; border-radius: var(--radius-lg); overflow: hidden;
            background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: var(--transition); height: 100%;
            display: flex; flex-direction: column;
        }
        .room-card:hover {
            transform: translateY(-8px); box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        }
        .room-card .img-wrapper {
            position: relative; overflow: hidden; height: 230px;
        }
        .room-card .img-wrapper img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s ease;
        }
        .room-card:hover .img-wrapper img { transform: scale(1.08); }

        .badge-glass {
            position: absolute; top: 14px; left: 14px;
            background: rgba(10,22,40,0.7); backdrop-filter: blur(10px);
            color: white; padding: 6px 14px; border-radius: 8px;
            font-size: 12px; font-weight: 600;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .badge-glass i { color: #fbbf24; }

        .room-card .card-body {
            padding: 24px; display: flex; flex-direction: column; flex-grow: 1;
        }
        .room-card .card-title {
            font-weight: 700; font-size: 20px; color: var(--navy); margin-bottom: 4px;
        }
        .room-rating {
            display: inline-flex; align-items: center; gap: 4px;
            background: rgba(201,168,76,0.12); color: var(--accent-gold);
            padding: 4px 10px; border-radius: 6px;
            font-size: 13px; font-weight: 700;
        }

        .room-facilities {
            display: flex; gap: 10px; flex-wrap: wrap; margin: 14px 0;
        }
        .room-facilities span {
            background: #f0f4ff; color: var(--accent-blue);
            padding: 5px 12px; border-radius: 6px;
            font-size: 12px; font-weight: 600;
        }

        .room-desc {
            font-size: 14px; color: var(--text-secondary);
            line-height: 1.6; flex-grow: 1; margin-bottom: 16px;
        }

        .card-footer-area {
            border-top: 1px solid #f0f1f5; padding-top: 18px; margin-top: auto;
        }
        .free-cancel {
            font-size: 13px; font-weight: 600; color: var(--success-green);
            margin-bottom: 12px; display: flex; align-items: center; gap: 6px;
        }
        .price-old {
            text-decoration: line-through; color: #ccc; font-size: 14px;
        }
        .price-from { font-size: 12px; color: var(--text-secondary); font-weight: 500; }
        .price-value { font-size: 22px; font-weight: 800; color: var(--success-green); line-height: 1; }

        .btn-detail-room {
            border-radius: 8px;
            background: linear-gradient(135deg, var(--navy), var(--navy-medium));
            color: white; border: none; padding: 10px 16px;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            transition: var(--transition); text-decoration: none; font-size: 14px; font-weight: 600;
        }
        .btn-detail-room:hover {
            transform: translateY(-2px); box-shadow: 0 8px 25px rgba(10,22,40,0.3); color: white;
        }

        /* Empty state */
        .empty-state {
            padding: 80px 20px; text-align: center;
        }
        .empty-state i { font-size: 60px; color: #d0d5dd; margin-bottom: 20px; }
        .empty-state h5 { color: var(--navy); font-weight: 700; margin-bottom: 10px;}
        .empty-state p { color: var(--text-secondary); }

        /* Search Filter Display */
        .search-info-bar {
            background: white; border-radius: var(--radius-md); padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-top: -30px; position: relative; z-index: 10;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;
        }
        .search-param {
            display: flex; flex-direction: column;
        }
        .search-param span.label { font-size: 12px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;}
        .search-param span.value { font-size: 16px; color: var(--navy); font-weight: 700; display: flex; align-items: center; gap: 8px;}
        .search-param span.value i { color: var(--accent-blue); }

        .btn-change-search {
            border: 2px solid var(--accent-blue); color: var(--accent-blue);
            background: transparent; padding: 8px 16px; border-radius: 50px;
            font-size: 14px; font-weight: 600; transition: var(--transition); text-decoration: none;
        }
        .btn-change-search:hover { background: var(--accent-blue); color: white; }

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

    <nav class="navbar navbar-expand-lg navbar-premium">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-detail" style="height: 280px;">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="fade-up" data-aos-duration="800">
            <div class="breadcrumb-custom">
                <a href="/"><i class="fa-solid fa-house"></i> Beranda</a>
                <span>/</span>
                <span style="color: rgba(255,255,255,0.8);">Hasil Pencarian</span>
            </div>
            <h1 style="font-size: 2.2rem;">Kamar Tersedia untuk Anda</h1>
        </div>
    </header>

    <div class="container">
        <div class="search-info-bar" data-aos="fade-up" data-aos-delay="100">
            <div class="d-flex gap-4 flex-wrap">
                <div class="search-param">
                    <span class="label">Check-in</span>
                    <span class="value"><i class="fa-regular fa-calendar"></i> {{ $checkIn->format('d M Y') }}</span>
                </div>
                <div class="search-param">
                    <span class="label">Check-out</span>
                    <span class="value"><i class="fa-regular fa-calendar-check"></i> {{ $checkOut->format('d M Y') }}</span>
                </div>
                <div class="search-param">
                    <span class="label">Durasi</span>
                    <span class="value"><i class="fa-solid fa-moon"></i> {{ $checkIn->diffInDays($checkOut) ?: 1 }} Malam</span>
                </div>
                <div class="search-param">
                    <span class="label">Lokasi</span>
                    <span class="value"><i class="fa-solid fa-location-dot"></i> {{ $location ?: 'Semua Lokasi' }}</span>
                </div>
            </div>
            <a href="/#hotel" class="btn-change-search"><i class="fa-solid fa-magnifying-glass me-2"></i>Ubah Pencarian</a>
        </div>
    </div>

    <section class="rooms-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-label">Hasil Pencarian</div>
                <h2 class="section-title-main">Kamar Sesuai Tanggal Anda</h2>
                <p class="section-subtitle">Kamar-kamar di bawah ini dipastikan tersedia pada tanggal pilihan Anda.</p>
            </div>

            <div class="row g-4">
                @forelse($availableRoomTypes as $room)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="room-card">
                        <div class="img-wrapper">
                            <img src="{{ Str::startsWith($room->foto_url, 'http') ? $room->foto_url : asset('storage/' . $room->foto_url) }}" alt="{{ $room->name }}">
                            <div class="badge-glass"><i class="fa-solid fa-check-circle me-1" style="color:var(--success-green);"></i> Tersedia</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $room->name }}</h5>
                                <span class="room-rating"><i class="fa-solid fa-location-dot me-1"></i>{{ $room->location ?: 'Pusat' }}</span>
                            </div>

                            <div class="room-facilities">
                                <span><i class="fa-solid fa-wifi me-1"></i>WiFi</span>
                                <span><i class="fa-solid fa-tv me-1"></i>TV Kabel</span>
                                <span><i class="fa-solid fa-wind me-1"></i>AC</span>
                            </div>

                            <p class="room-desc">{{ Str::limit($room->description, 80) }}</p>

                            <div class="card-footer-area">
                                <div class="free-cancel"><i class="fa-solid fa-check-circle"></i> Pesan Cepat & Aman</div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <span class="price-from">Biaya Per Malam</span>
                                        <div class="price-value">Rp {{ number_format($room->price, 0, ',', '.') }}</div>
                                    </div>
                                    <a href="{{ route('booking.form', ['id' => $room->id, 'check_in' => $checkIn->format('Y-m-d'), 'check_out' => $checkOut->format('Y-m-d')]) }}" class="btn-detail-room">
                                        Pesan Sekarang <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state" data-aos="fade-up">
                        <i class="fa-solid fa-calendar-xmark"></i>
                        <h5>Kamar Penuh Pada Tanggal Tersebut</h5>
                        <p>Maaf, seluruh kamar pada rentang tanggal {{ $checkIn->format('d M') }} - {{ $checkOut->format('d M') }} sudah dipesan oleh tamu lain. Silakan ubah tanggal atau cari lokasi lain.</p>
                        <a href="/" class="btn-change-search mt-3 d-inline-block">Cari Tanggal Lain</a>
                    </div>
                </div>
                @endforelse
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
