<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar di Premium Hotel {{ $location }} - Hotelku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #0f294d;
            --light-blue: #3264ff;
            --bg-gray: #f5f7fa;
            --price-orange: #ff5e1f;
        }
        body { background-color: var(--bg-gray); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .navbar-custom { background-color: white !important; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .navbar-custom .navbar-brand { color: var(--primary-blue) !important; font-size: 24px; font-weight: 800; }
        .navbar-custom .nav-link { color: #333 !important; font-weight: 500; padding: 10px 15px; }
        .navbar-custom .nav-link:hover { color: var(--light-blue) !important; }
        
        .hero-section {
            background: linear-gradient(to bottom, rgba(15, 41, 77, 0.4), rgba(15, 41, 77, 0.8)), url('https://images.unsplash.com/photo-1542314831-c6a4d1409b1c?q=80&w=1920&auto=format&fit=crop') center/cover;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
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
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Kembali ke Beranda</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Premium Hotel {{ $location ?: 'Pusat' }}</h1>
            <p class="lead fs-4" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Pilih tipe kamar yang sesuai dengan kebutuhan Anda di cabang ini.</p>
        </div>
    </header>

    <section id="kamar" class="py-5" style="background-color: white;">
        <div class="container">
            <h3 class="fw-bold mb-1" style="color: var(--primary-blue);">Pilihan Kamar Populer</h3>
            <p class="text-muted mb-4">Direkomendasikan berdasarkan penilaian pelanggan di cabang {{ $location ?: 'Pusat' }}.</p>
            
            <div class="row g-4">
                @forelse($roomTypes as $room)
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm room-card h-100">
                        <div class="room-image-container">
                            <img src="{{ Str::startsWith($room->foto_url, 'http') ? $room->foto_url : asset('storage/' . $room->foto_url) }}" class="card-img-top" alt="{{ $room->name }}" style="height: 220px; object-fit: cover;">
                            <div class="room-badge"><i class="fa-solid fa-fire text-warning me-1"></i> Sering Dipesan</div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0">{{ $room->name }}</h5>
                                <div class="text-end">
                                    <span class="badge bg-primary"><i class="fa-solid fa-star text-warning"></i> 4.8 / 5</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <span class="facility-icon"><i class="fa-solid fa-wifi"></i> WiFi</span>
                                <span class="facility-icon"><i class="fa-solid fa-tv"></i> TV Kabel</span>
                                <span class="facility-icon"><i class="fa-solid fa-wind"></i> AC</span>
                            </div>
                            
                            <p class="card-text text-muted small flex-grow-1">{{ $room->description }}</p>
                            
                            <div class="mt-auto border-top pt-3">
                                <p class="text-success small fw-bold mb-1"><i class="fa-solid fa-check me-1"></i> Pembatalan Gratis</p>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <div class="text-muted text-decoration-line-through small">Rp {{ number_format($room->price + 250000, 0, ',', '.') }}</div>
                                        <div>
                                            <span class="d-block text-muted small">Mulai Dari</span>
                                            <h4 class="text-success fw-bold mb-0">Rp {{ number_format($room->price, 0, ',', '.') }}</h4>
                                        </div>
                                    </div>
                                    <a href="{{ route('room.detail', $room->id) }}" class="btn btn-primary d-flex align-items-center rounded-3"><i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 py-5 text-center">
                    <i class="fa-solid fa-bed-pulse fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Maaf, belum ada data kamar untuk cabang ini.</h5>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="pt-5 pb-4" style="background-color: var(--primary-blue); color: #d0d7e5;">
        <div class="container">
            <div class="text-center small opacity-75 mt-3">
                &copy; {{ date('Y') }} Hotelku. Sistem Informasi setara OTA Profesional.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
