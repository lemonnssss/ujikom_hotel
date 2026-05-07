<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pesan {{ $menu->name }} dari restoran hotel kami langsung ke kamar Anda.">
    <title>Pesan {{ $menu->name }} | Hotelku Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0a1628;
            --navy-light: #132240;
            --accent-gold: #c9a84c;
            --accent-gold-light: #e4cc7a;
            --accent-orange: #ff8c42;
            --accent-orange-dark: #e8590c;
            --accent-blue: #4a7cff;
            --accent-blue-glow: rgba(74, 124, 255, 0.25);
            --warm-white: #faf9f6;
            --text-secondary: #a0a8b8;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--warm-white);
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-premium {
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(20px);
            padding: 14px 0;
            box-shadow: 0 4px 30px rgba(0,0,0,0.2);
        }
        .navbar-premium .navbar-brand {
            font-size: 24px; font-weight: 800; color: white !important;
        }
        .navbar-premium .navbar-brand i { color: var(--accent-gold); }

        /* Order Layout */
        .order-section { padding: 40px 0 80px; }

        .order-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 40px rgba(0,0,0,0.07);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.04);
        }

        .img-side {
            position: relative;
            overflow: hidden;
            height: 100%;
            min-height: 520px;
        }
        .img-side img {
            width: 100%; height: 100%;
            object-fit: cover; position: absolute;
            top: 0; left: 0;
            transition: transform 8s ease;
        }
        .order-card:hover .img-side img {
            transform: scale(1.05);
        }
        .img-overlay {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: linear-gradient(transparent, rgba(10,22,40,0.7));
            padding: 30px;
        }
        .img-overlay .menu-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255, 140, 66, 0.9);
            color: white; padding: 6px 16px;
            border-radius: 50px; font-size: 13px;
            font-weight: 700;
        }

        .form-side { padding: 40px; }

        /* Menu Info Header */
        .menu-name {
            font-size: 28px; font-weight: 800;
            color: var(--navy); margin-bottom: 8px;
        }
        .menu-desc {
            font-size: 15px; color: var(--text-secondary);
            line-height: 1.7; margin-bottom: 20px;
        }
        .price-badge-orange {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, var(--accent-orange), var(--accent-orange-dark));
            color: white; padding: 10px 24px;
            border-radius: 50px; font-weight: 700;
            font-size: 16px; margin-bottom: 28px;
            box-shadow: 0 6px 20px rgba(255, 140, 66, 0.3);
        }

        /* Form Section */
        .form-section-title {
            font-size: 16px; font-weight: 700; color: var(--navy);
            margin-bottom: 20px; padding-bottom: 12px;
            border-bottom: 2px solid #f0f1f5;
            display: flex; align-items: center; gap: 10px;
        }
        .form-section-title i { color: var(--accent-orange); font-size: 18px; }

        .form-label {
            font-weight: 600; font-size: 13px;
            color: #5a6577; margin-bottom: 8px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .form-control {
            border: 2px solid #eef0f5;
            border-radius: var(--radius-sm);
            padding: 13px 15px;
            font-weight: 500; font-size: 15px;
            transition: var(--transition);
            background: #f8f9fc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-control:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 4px rgba(255, 140, 66, 0.15);
            background: white;
        }
        .input-group-text {
            background: #f8f9fc;
            border: 2px solid #eef0f5;
            border-right: none;
            color: var(--accent-orange);
        }
        .input-group .form-control { border-left: none; }
        .input-group:focus-within .input-group-text {
            border-color: var(--accent-orange);
        }

        /* Buttons */
        .btn-back {
            background: white; color: #5a6577;
            border: 2px solid #eef0f5;
            padding: 15px 24px; border-radius: var(--radius-sm);
            font-weight: 600; font-size: 15px;
            transition: var(--transition);
            text-decoration: none;
            display: flex; align-items: center; gap: 8px; justify-content: center;
        }
        .btn-back:hover {
            border-color: #d0d5dd; background: #f8f9fc; color: var(--navy);
        }

        .btn-order-submit {
            background: linear-gradient(135deg, var(--accent-orange), var(--accent-orange-dark));
            color: white; border: none;
            padding: 15px 24px; border-radius: var(--radius-sm);
            font-weight: 700; font-size: 15px;
            transition: var(--transition);
            display: flex; align-items: center; gap: 8px; justify-content: center;
            box-shadow: 0 8px 25px rgba(255, 140, 66, 0.3);
        }
        .btn-order-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255, 140, 66, 0.4);
            color: white;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1.5px solid rgba(239, 68, 68, 0.2);
            border-radius: var(--radius-md);
            color: #dc2626; padding: 14px 20px;
            font-weight: 500; font-size: 14px;
        }

        @media (max-width: 767px) {
            .img-side { min-height: 250px; }
            .form-side { padding: 28px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-premium sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
    </div>
</nav>

<div class="order-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">

                @if(session('error'))
                    <div class="alert-error mb-4">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <div class="order-card">
                    <div class="row g-0">
                        <div class="col-md-5 d-none d-md-block">
                            <div class="img-side">
                                <img src="{{ Str::startsWith($menu->foto_url, 'http') ? $menu->foto_url : asset('storage/' . $menu->foto_url) }}" alt="{{ $menu->name }}">
                                <div class="img-overlay">
                                    <div class="menu-badge"><i class="fa-solid fa-utensils"></i> Restoran Hotel</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-side">
                                <h2 class="menu-name">{{ $menu->name }}</h2>
                                <p class="menu-desc">{{ $menu->description }}</p>
                                <div class="price-badge-orange">
                                    <i class="fa-solid fa-tag"></i> Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </div>

                                <form action="{{ route('restaurant.store', $menu->id) }}" method="POST">
                                    @csrf

                                    <div class="form-section-title">
                                        <i class="fa-solid fa-user"></i> Informasi Pemesan
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label class="form-label">Nomor WhatsApp</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-brands fa-whatsapp"></i></span>
                                                <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No. Kamar (Opsional)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-door-closed"></i></span>
                                                <input type="text" name="room_number" class="form-control" placeholder="Mis. 101">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section-title mt-4">
                                        <i class="fa-solid fa-utensils"></i> Detail Pesanan
                                    </div>
                                    <div class="row mb-4 align-items-start">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <label class="form-label">Jumlah Porsi</label>
                                            <div class="input-group">
                                                <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                                                <span class="input-group-text" style="border-left: none; border-right: 2px solid #eef0f5;">Porsi</span>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-regular fa-comment-dots"></i></span>
                                                <input type="text" name="note" class="form-control" placeholder="Mis. Pedas, tanpa bawang...">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="form-section-title mt-4">
                                        <i class="fa-solid fa-credit-card"></i> Metode Pembayaran
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <div class="d-flex gap-3 flex-wrap">
                                                <div class="form-check" style="background: #f8f9fc; padding: 12px 20px 12px 40px; border-radius: 10px; border: 2px solid #eef0f5; flex: 1;">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="pay_online" value="online" checked style="margin-top: 6px;">
                                                    <label class="form-check-label fw-bold" for="pay_online">
                                                        Bayar Online (Midtrans)
                                                        <div class="text-muted" style="font-size: 12px; font-weight: normal;">Transfer Bank, E-Wallet, QRIS, Kartu Kredit</div>
                                                    </label>
                                                </div>
                                                <div class="form-check" style="background: #f8f9fc; padding: 12px 20px 12px 40px; border-radius: 10px; border: 2px solid #eef0f5; flex: 1;">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="pay_offline" value="offline" style="margin-top: 6px;">
                                                    <label class="form-check-label fw-bold" for="pay_offline">
                                                        Bayar di Tempat (Offline)
                                                        <div class="text-muted" style="font-size: 12px; font-weight: normal;">Bayar saat pesanan diantar ke kamar / meja</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column flex-md-row gap-3 mt-5">
                                        <a href="/#restoran" class="btn-back w-100"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                                        <button type="submit" class="btn-order-submit w-100">
                                            <i class="fa-solid fa-cart-shopping"></i> Pesan Sekarang
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });</script>
</body>
</html>