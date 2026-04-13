<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kamar - {{ $roomType->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .hero-img { height: 450px; object-fit: cover; border-radius: 20px; width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .feature-box { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .price-badge { background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white; padding: 15px 25px; border-radius: 15px; display: inline-block; }
        .btn-booking { background: linear-gradient(135deg, #3264ff 0%, #1a42ba 100%); color: white; border: none; padding: 15px 30px; border-radius: 12px; font-weight: 600; box-shadow: 0 5px 20px rgba(50, 100, 255, 0.3); transition: all 0.3s; }
        .btn-booking:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(50, 100, 255, 0.4); color: white;}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/"><i class="fa-solid fa-hotel text-primary me-2"></i>Hotelku</a>
    </div>
</nav>

<div class="container py-5">
    
    <div class="mb-4">
        <a href="/" class="text-decoration-none text-muted"><i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Beranda</a>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <img src="{{ Str::startsWith($roomType->foto_url, 'http') ? $roomType->foto_url : asset('storage/' . $roomType->foto_url) }}" class="hero-img" alt="{{ $roomType->name }}">
        </div>
        <div class="col-lg-5 ps-lg-5">
            <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill"><i class="fa-solid fa-star text-warning me-1"></i> Highly Recommended</span>
            <h1 class="fw-bold mb-3">{{ $roomType->name }}</h1>
            <p class="text-muted fs-5 mb-4">{{ $roomType->location ?? 'Lokasi Utama' }}</p>
            
            <div class="price-badge mb-4">
                <span class="d-block small text-white-50 mb-1">Mulai Dari</span>
                <h2 class="fw-bold mb-0">Rp {{ number_format($roomType->price, 0, ',', '.') }}<span class="fs-6 fw-normal text-white-50"> / malam</span></h2>
            </div>
            
            <p class="mb-4 text-secondary lh-lg">{{ $roomType->description ?? 'Nikmati kenyamanan beristirahat di ruangan pilihan kami yang didesain secara khusus untuk memenuhi segala kebutuhan eksklusif Anda selama menginap.' }}</p>

            <a href="{{ route('booking.form', $roomType->id) }}" class="btn btn-booking w-100 fs-5"><i class="fa-solid fa-calendar-check me-2"></i> Pesan Kamar Sekarang</a>
            
            <div class="mt-3 text-center text-muted small">
                @if($availableRooms > 0)
                    <span class="text-success"><i class="fa-solid fa-circle-check me-1"></i>Tersedia <b>{{ $availableRooms }}</b> kamar kosong hari ini!</span>
                @else
                    <span class="text-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Stok untuk Check-in hari ini penuh / Silakan atur tanggal esok di form pemesanan</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Fasilitas Utama</h3>
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="feature-box text-center">
                        <i class="fa-solid fa-wifi text-primary fa-2x mb-3"></i>
                        <h6 class="fw-bold">Free Wi-Fi</h6>
                        <p class="text-muted small mb-0">Kecepatan hingga 100Mbps</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-box text-center">
                        <i class="fa-solid fa-tv text-primary fa-2x mb-3"></i>
                        <h6 class="fw-bold">Smart TV 43"</h6>
                        <p class="text-muted small mb-0">Dilengkapi Netflix & YouTube</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-box text-center">
                        <i class="fa-solid fa-shower text-primary fa-2x mb-3"></i>
                        <h6 class="fw-bold">Water Heater</h6>
                        <p class="text-muted small mb-0">Kamar mandi dalam khusus</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-box text-center">
                        <i class="fa-solid fa-mug-hot text-primary fa-2x mb-3"></i>
                        <h6 class="fw-bold">Breakfast</h6>
                        <p class="text-muted small mb-0">Sarapan Pagi Eksklusif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
