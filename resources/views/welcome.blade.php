<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotelku - Pesan Kamar & Pengalaman Menginap Terbaik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Warna khas Trip.com / OTA Profesional */
        :root {
            --primary-blue: #0f294d;
            --light-blue: #3264ff;
            --bg-gray: #f5f7fa;
            --price-orange: #ff5e1f;
        }
        
        body { background-color: var(--bg-gray); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navbar modern putih bersih */
        .navbar-custom { background-color: white !important; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .navbar-custom .navbar-brand { color: var(--primary-blue) !important; font-size: 24px; font-weight: 800; }
        .navbar-custom .nav-link { color: #333 !important; font-weight: 500; padding: 10px 15px; }
        .navbar-custom .nav-link:hover { color: var(--light-blue) !important; }
        
        /* Hero Section dengan Gambar Besar */
        .hero-section {
            background: linear-gradient(to bottom, rgba(15, 41, 77, 0.4), rgba(15, 41, 77, 0.8)), url('https://images.unsplash.com/photo-1542314831-c6a4d1409b1c?q=80&w=1920&auto=format&fit=crop') center/cover;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding-bottom: 50px; /* Ruang untuk floating box */
        }

        /* Floating Search Box (Kunci utama desain OTA) */
        .search-widget {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-top: -60px; /* Menarik box ke atas menembus hero */
            position: relative;
            z-index: 10;
        }

        .search-btn {
            background-color: var(--light-blue);
            color: white;
            font-weight: bold;
            font-size: 18px;
            height: 100%;
        }
        .search-btn:hover { background-color: #234ee0; color: white; }

        /* Card Kamar ala Agoda/Trip.com */
        .room-card { border: none; border-radius: 10px; overflow: hidden; transition: all 0.3s ease; }
        .room-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .room-image-container { position: relative; }
        .room-badge { position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; }
        .price-text { color: var(--price-orange); font-size: 24px; font-weight: 800; }
        
        .facility-icon { color: #5aa17f; font-size: 14px; margin-right: 15px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#kamar">Akomodasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#restoran">Restoran & Kuliner</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Fasilitas</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    @auth
                        <a href="/dashboard" class="btn btn-outline-primary fw-bold rounded-pill px-4">Dashboard Saya</a>
                    @else
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold me-4" style="color: var(--primary-blue);">Daftar</a>
                        <a href="{{ route('login') }}" class="btn fw-bold rounded-pill px-4" style="background-color: var(--light-blue); color: white;">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Temukan Pengalaman Menginap Luar Biasa</h1>
            <p class="lead fs-4" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Pesan langsung dari web kami untuk harga terbaik & bebas biaya admin.</p>
        </div>
    </header>

    <div class="container">
        <div class="search-widget">
            <form action="#kamar" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold mb-1">Cek Ketersediaan (Check-in)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-regular fa-calendar"></i></span>
                            <input type="date" class="form-control border-start-0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold mb-1">Check-out</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-regular fa-calendar-check"></i></span>
                            <input type="date" class="form-control border-start-0" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="text-muted small fw-bold mb-1">Tamu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-user"></i></span>
                            <select class="form-select border-start-0">
                                <option>1 Dewasa</option>
                                <option selected>2 Dewasa</option>
                                <option>Keluarga</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="text-white small mb-1 d-none d-md-block">.</label>
                        <button type="submit" class="btn search-btn w-100 rounded">Cari Kamar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container mt-5 pt-3">
        <div class="row text-center mb-5">
            <div class="col-md-4 mb-3">
                <i class="fa-solid fa-shield-halved fa-2x mb-2" style="color: var(--light-blue);"></i>
                <h6 class="fw-bold">Pemesanan Aman</h6>
                <p class="text-muted small">Data Anda dilindungi enkripsi standar industri.</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fa-solid fa-tag fa-2x mb-2" style="color: var(--light-blue);"></i>
                <h6 class="fw-bold">Jaminan Harga Terbaik</h6>
                <p class="text-muted small">Tidak ada biaya tersembunyi. Bayar sesuai yang Anda lihat.</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fa-solid fa-headset fa-2x mb-2" style="color: var(--light-blue);"></i>
                <h6 class="fw-bold">Layanan 24/7</h6>
                <p class="text-muted small">Resepsionis kami siap membantu Anda kapan saja.</p>
            </div>
        </div>
    </div>

    <section id="kamar" class="py-5" style="background-color: white;">
        <div class="container">
            <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Destinasi Hotel Kami</h3>
            <p class="text-muted mb-4">Pilih lokasi hotel untuk melihat tipe kamar yang tersedia.</p>
            
            <div class="row g-4">
                @foreach($hotels as $hotel)
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm room-card h-100">
                        <div class="room-image-container">
                            <img src="{{ Str::startsWith($hotel->foto_url, 'http') ? $hotel->foto_url : asset('storage/' . $hotel->foto_url) }}" class="card-img-top" alt="{{ $hotel->name }}" style="height: 220px; object-fit: cover;">
                            <div class="room-badge"><i class="fa-solid fa-building text-warning me-1"></i> {{ $hotel->room_count }} Tipe Kamar</div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0">{{ $hotel->name }}</h5>
                                <div class="text-end">
                                    <span class="badge bg-primary"><i class="fa-solid fa-star text-warning"></i> 5.0 / 5</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <span class="facility-icon"><i class="fa-solid fa-map-marker-alt"></i> Lokasi Strategis di {{ $hotel->location }}</span>
                                <span class="facility-icon"><i class="fa-solid fa-swimming-pool"></i> Kolam Renang Umum</span>
                            </div>
                            
                            <p class="card-text text-muted small flex-grow-1">Pengalaman menginap tak terlupakan. Fasilitas lengkap dan pelayanan bintang lima menanti Anda dan keluarga.</p>
                            
                            <div class="mt-auto border-top pt-3">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <span class="d-block text-muted small">Mulai Dari</span>
                                        <h4 class="text-success fw-bold mb-0">Rp {{ number_format($hotel->min_price, 0, ',', '.') }}</h4>
                                    </div>
                                    <a href="{{ route('hotel.detail', urlencode($hotel->location)) }}" class="btn btn-primary d-flex align-items-center rounded-3 px-4"><i class="fa-solid fa-arrow-right me-2"></i>Pilih Kamar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="restoran" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Restoran & Layanan Kamar</h3>
                    <p class="text-muted mb-0">Pesan makanan favorit Anda langsung ke kamar.</p>
                </div>
            </div>
            
            <div class="row g-4">
                @foreach($menus as $menu)
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden room-card">
                        <img src="{{ Str::startsWith($menu->foto_url, 'http') ? $menu->foto_url : asset('storage/' . $menu->foto_url) }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 160px; object-fit: cover;">
                        <div class="card-body text-center p-3 d-flex flex-column">
                            <h6 class="fw-bold mb-1">{{ $menu->name }}</h6>
                            <p class="text-muted small mb-3 flex-grow-1" style="font-size: 12px;">{{ $menu->description }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold" style="color: var(--price-orange);">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <a href="/restaurant-order/{{ $menu->id }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Pesan</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="pt-5 pb-4" style="background-color: var(--primary-blue); color: #d0d7e5;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <h4 class="text-white fw-bold mb-3"><i class="fa-solid fa-hotel me-2"></i>Hotelku</h4>
                    <p class="small">Platform reservasi kamar dan layanan terpadu yang didesain untuk kenyamanan maksimal. Kami menjamin harga terbaik untuk setiap pemesanan langsung melalui sistem ini.</p>
                </div>
                <div class="col-md-2 col-6 mb-4">
                    <h6 class="text-white fw-bold mb-3">Tentang</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light opacity-75">Profil Hotel</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light opacity-75">Karir</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light opacity-75">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h6 class="text-white fw-bold mb-3">Layanan Pelanggan</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light opacity-75">Bantuan & FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light opacity-75">Cara Memesan</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light opacity-75">Aturan Pembatalan</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="text-white fw-bold mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i> Jl. Pariwisata No. 123</li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2"></i> +62 800 1234 5678</li>
                        <li class="mb-2"><i class="fa-solid fa-envelope me-2"></i> cs@hotelku.com</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center small opacity-75 mt-3">
                &copy; {{ date('Y') }} Hotelku. Sistem Informasi setara OTA Profesional.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>