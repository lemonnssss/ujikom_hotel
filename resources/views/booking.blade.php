<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form pemesanan kamar {{ $roomType->name }} - Isi data tamu dan tanggal menginap Anda.">
    <title>Booking {{ $roomType->name }} | Hotelku</title>
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

        /* Steps */
        .steps-bar {
            background: white;
            border-bottom: 1px solid #eef0f5;
            padding: 20px 0;
        }
        .steps-list {
            display: flex; align-items: center;
            justify-content: center; gap: 12px;
            list-style: none; padding: 0; margin: 0;
            flex-wrap: wrap;
        }
        .step-item {
            display: flex; align-items: center; gap: 10px;
            font-size: 14px; font-weight: 600; color: #c0c5d0;
        }
        .step-item.active { color: var(--accent-blue); }
        .step-item.done { color: var(--success-green); }
        .step-num {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
            background: #eef0f5; color: #c0c5d0;
        }
        .step-item.active .step-num {
            background: var(--accent-blue); color: white;
            box-shadow: 0 4px 12px rgba(74, 124, 255, 0.3);
        }
        .step-item.done .step-num {
            background: var(--success-green); color: white;
        }
        .step-divider {
            width: 40px; height: 2px;
            background: #eef0f5; border-radius: 2px;
        }

        /* Main Card */
        .booking-main { padding: 40px 0 80px; }

        .booking-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 40px rgba(0,0,0,0.07);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.04);
        }

        .card-header-premium {
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            color: white; padding: 28px 36px;
        }
        .card-header-premium h3 { font-weight: 800; font-size: 22px; margin-bottom: 4px; }
        .card-header-premium .sub-header {
            color: rgba(255,255,255,0.6); font-size: 15px;
            display: flex; align-items: center; gap: 8px;
        }
        .card-header-premium .price-top {
            text-align: right;
        }
        .card-header-premium .price-label-top {
            font-size: 12px; color: rgba(255,255,255,0.5); font-weight: 500;
        }
        .card-header-premium .price-value-top {
            font-size: 24px; font-weight: 800; color: var(--accent-gold-light);
        }

        .card-form-body { padding: 36px; }

        /* Section Titles */
        .form-section-title {
            font-size: 18px; font-weight: 700; color: var(--navy);
            margin-bottom: 24px; padding-bottom: 14px;
            border-bottom: 2px solid #f0f1f5;
            display: flex; align-items: center; gap: 10px;
        }
        .form-section-title i {
            color: var(--accent-blue); font-size: 20px;
        }

        /* Inputs */
        .form-label {
            font-weight: 600; font-size: 13px;
            color: #5a6577; margin-bottom: 8px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .form-control {
            border: 2px solid #eef0f5;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-weight: 500; font-size: 15px;
            transition: var(--transition);
            background: #f8f9fc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 4px var(--accent-blue-glow);
            background: white;
        }

        .input-group-text {
            background: #f8f9fc;
            border: 2px solid #eef0f5;
            border-right: none;
            color: var(--accent-blue);
            font-size: 16px;
        }
        .input-group .form-control {
            border-left: none;
        }
        .input-group .form-control:focus {
            border-left: none;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--accent-blue);
        }

        /* Price Summary */
        .price-summary {
            background: linear-gradient(135deg, rgba(52, 199, 123, 0.08), rgba(52, 199, 123, 0.04));
            border: 1.5px solid rgba(52, 199, 123, 0.2);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            display: none;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
            animation: fadeSlideIn 0.4s ease;
        }
        .price-summary.show { display: flex; }

        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .price-summary .summary-label h6 {
            font-weight: 700; color: var(--navy); font-size: 15px;
            margin-bottom: 2px;
        }
        .price-summary .summary-label p {
            font-size: 13px; color: var(--text-secondary); margin: 0;
        }
        .price-summary .summary-value {
            font-size: 24px; font-weight: 800; color: var(--success-green);
        }

        /* Buttons */
        .btn-back {
            background: white; color: #5a6577;
            border: 2px solid #eef0f5;
            padding: 16px 28px; border-radius: var(--radius-sm);
            font-weight: 600; font-size: 15px;
            transition: var(--transition);
            text-decoration: none;
            display: flex; align-items: center; gap: 8px;
            justify-content: center;
        }
        .btn-back:hover {
            border-color: #d0d5dd; background: #f8f9fc; color: var(--navy);
        }

        .btn-submit-booking {
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            color: var(--navy);
            border: none;
            padding: 16px 28px; border-radius: var(--radius-sm);
            font-weight: 700; font-size: 15px;
            transition: var(--transition);
            display: flex; align-items: center; gap: 8px;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3);
        }
        .btn-submit-booking:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(201, 168, 76, 0.4);
            color: var(--navy);
        }

        /* Alert */
        .alert-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1.5px solid rgba(239, 68, 68, 0.2);
            border-radius: var(--radius-md);
            color: #dc2626;
            padding: 14px 20px;
            font-weight: 500;
            font-size: 14px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-premium sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
    </div>
</nav>

<!-- Steps Indicator -->
<div class="steps-bar">
    <div class="container">
        <ul class="steps-list">
            <li class="step-item done"><span class="step-num"><i class="fa-solid fa-check"></i></span> Pilih Kamar</li>
            <div class="step-divider"></div>
            <li class="step-item active"><span class="step-num">2</span> Isi Data</li>
            <div class="step-divider"></div>
            <li class="step-item"><span class="step-num">3</span> Pembayaran</li>
        </ul>
    </div>
</div>

<div class="booking-main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">

                @if(session('error'))
                    <div class="alert-error mb-4">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <div class="booking-card">
                    <div class="card-header-premium d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Konfirmasi Pemesanan</h3>
                            <div class="sub-header"><i class="fa-solid fa-bed"></i> {{ $roomType->name }}</div>
                        </div>
                        <div class="price-top">
                            <div class="price-label-top">Harga per malam</div>
                            <div class="price-value-top">Rp {{ number_format($roomType->price, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="card-form-body">
                        <form action="{{ route('booking.store', $roomType->id) }}" method="POST">
                            @csrf

                            <!-- Guest Info -->
                            <div class="form-section-title">
                                <i class="fa-solid fa-user-circle"></i> Informasi Tamu
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-brands fa-whatsapp"></i></span>
                                        <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">NIK (Nomor KTP)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                                        <input type="text" name="identity_number" class="form-control" placeholder="16 Digit NIK" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-map-location-dot"></i></span>
                                        <input type="text" name="address" class="form-control" placeholder="Jl. Contoh No. 123" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="form-section-title mt-5">
                                <i class="fa-solid fa-calendar-days"></i> Detail Jadwal
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Tanggal Check-In</label>
                                    <input type="date" name="check_in" id="check_in" class="form-control" 
                                           value="{{ $checkIn ?? '' }}" {{ !empty($checkIn) ? 'readonly' : 'required' }} min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Check-Out</label>
                                    <input type="date" name="check_out" id="check_out" class="form-control" 
                                           value="{{ $checkOut ?? '' }}" {{ !empty($checkOut) ? 'readonly' : 'required' }} min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label">Jumlah Kamar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-door-closed"></i></span>
                                        <input type="number" name="room_qty" id="room_qty" class="form-control" value="1" min="1" max="5" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label">Tamu Dewasa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                        <input type="number" name="adults_count" class="form-control" value="1" min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Anak-anak</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-child"></i></span>
                                        <input type="number" name="children_count" class="form-control" value="0" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Tipe Tempat Tidur (Bed Type)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-bed"></i></span>
                                    <select name="bed_type" class="form-control" required>
                                        <option value="double">Double Bed (Untuk 2 Orang) - Harga Normal</option>
                                        <option value="single">Single Bed (Untuk 1 Orang) - Lebih hemat Rp 50.000/malam</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Permintaan Khusus (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-regular fa-comment-dots"></i></span>
                                    <textarea name="special_requests" class="form-control" rows="2" placeholder="Contoh: Kamar berdekatan, lantai atas, dsb..."></textarea>
                                </div>
                            </div>

                            <!-- Restaurant Packages -->
                            <div class="form-section-title mt-5">
                                <i class="fa-solid fa-utensils"></i> Paket Tambahan Restoran
                            </div>
                            
                            <div class="row g-3 mb-4">
                                @forelse($menus as $menu)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0" style="background:#f8f9fc; border-radius:10px;">
                                        <div class="card-body p-3 text-center">
                                            @if($menu->foto_url)
                                            <img src="{{ Str::startsWith($menu->foto_url, 'http') ? $menu->foto_url : asset('storage/' . $menu->foto_url) }}" alt="{{ $menu->name }}" class="img-fluid rounded mb-2" style="height: 100px; object-fit: cover; width: 100%;">
                                            @endif
                                            <h6 class="fw-bold mb-1" style="font-size:14px; color:var(--navy);">{{ $menu->name }}</h6>
                                            <p class="mb-2" style="font-size:12px; color:var(--text-secondary);">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                            <div class="input-group input-group-sm mb-0">
                                                <span class="input-group-text bg-white">Qty</span>
                                                <input type="number" name="menus[{{ $menu->id }}][qty]" class="form-control text-center menu-qty" value="0" min="0" data-price="{{ $menu->price }}">
                                                <input type="hidden" name="menus[{{ $menu->id }}][id]" value="{{ $menu->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted">
                                    <p style="font-size: 14px;">Belum ada menu restoran tersedia saat ini.</p>
                                </div>
                                @endforelse
                            </div>

                            <!-- Voucher -->
                            <div class="card border-0 mb-4" style="background:#f0f4f8; border-radius:10px;">
                                <div class="card-body p-3">
                                    <label class="form-label mb-2" style="font-weight: 600; font-size: 14px; color: var(--navy);"><i class="fa-solid fa-ticket text-primary"></i> Punya Kode Voucher?</label>
                                    <div class="input-group">
                                        <input type="text" id="voucher_code" name="voucher_code" class="form-control border-0" placeholder="Ketik kode promo...">
                                        <button class="btn btn-primary" type="button" id="btn-check-voucher" style="border-radius: 0 8px 8px 0; font-weight: 600;">Terapkan</button>
                                    </div>
                                    <div id="voucher-message" class="mt-2" style="font-size: 13px; display: none; font-weight: 500;"></div>
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
                                                <div class="text-muted" style="font-size: 12px; font-weight: normal;">Bayar langsung saat datang ke resepsionis</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Summary -->
                            <div class="price-summary" id="price-summary">
                                <div class="summary-label">
                                    <h6><i class="fa-solid fa-receipt me-2"></i>Total Pembayaran</h6>
                                    <p><span id="days-count">0</span> malam × Rp {{ number_format($roomType->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="summary-value" id="total-price-display">Rp 0</div>
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                                <a href="/" class="btn-back w-100"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn-submit-booking w-100">
                                    <i class="fa-solid fa-check-circle"></i> Selesaikan Pemesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });

    document.addEventListener('DOMContentLoaded', function() {
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const roomQtyInput = document.getElementById('room_qty');
        const bedTypeInput = document.querySelector('select[name="bed_type"]');
        const pricePerNight = {{ $roomType->price }};
        const summaryContainer = document.getElementById('price-summary');
        const daysCountSpan = document.getElementById('days-count');
        const totalPriceDisplay = document.getElementById('total-price-display');

        let activeVoucher = null;

        document.getElementById('btn-check-voucher').addEventListener('click', function() {
            const code = document.getElementById('voucher_code').value;
            const messageEl = document.getElementById('voucher-message');
            
            if(!code) return;
            
            fetch('/check-voucher', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                messageEl.style.display = 'block';
                if(data.success) {
                    activeVoucher = data.voucher;
                    messageEl.className = 'mt-2 text-success';
                    messageEl.innerHTML = '<i class="fa-solid fa-check-circle"></i> ' + data.message;
                    calculateTotal();
                } else {
                    activeVoucher = null;
                    messageEl.className = 'mt-2 text-danger';
                    messageEl.innerHTML = '<i class="fa-solid fa-times-circle"></i> ' + data.message;
                    calculateTotal();
                }
            }).catch(err => console.error(err));
        });

        function calculateTotal() {
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);

            if (checkInInput.value && checkOutInput.value && checkOutDate > checkInDate) {
                summaryContainer.classList.add('show');

                const diffTime = Math.abs(checkOutDate - checkInDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const roomQty = parseInt(roomQtyInput.value) || 1;
                
                let currentPricePerNight = pricePerNight;
                if (bedTypeInput && bedTypeInput.value === 'single') {
                    currentPricePerNight -= 50000;
                }

                daysCountSpan.textContent = diffDays + " malam × " + roomQty + " kamar (" + (bedTypeInput.value === 'single' ? 'Single Bed' : 'Double Bed') + ")";

                const roomTotalPrice = diffDays * currentPricePerNight * roomQty;
                
                let restaurantTotal = 0;
                document.querySelectorAll('.menu-qty').forEach(function(input) {
                    const qty = parseInt(input.value) || 0;
                    const price = parseFloat(input.dataset.price) || 0;
                    restaurantTotal += qty * price;
                });

                let totalPrice = roomTotalPrice + restaurantTotal;
                let discountText = '';
                
                if (activeVoucher) {
                    let discountAmount = 0;
                    if (activeVoucher.type === 'percent') {
                        discountAmount = roomTotalPrice * (activeVoucher.value / 100);
                    } else {
                        discountAmount = parseFloat(activeVoucher.value);
                    }
                    if(discountAmount > roomTotalPrice) discountAmount = roomTotalPrice;
                    
                    totalPrice -= discountAmount;
                    discountText = `<div class="text-success small mt-1"><i class="fa-solid fa-tags"></i> Potongan Voucher: -Rp ${discountAmount.toLocaleString('id-ID')}</div>`;
                }

                totalPriceDisplay.innerHTML = 'Rp ' + totalPrice.toLocaleString('id-ID') + discountText;
            } else {
                summaryContainer.classList.remove('show');
            }
        }

        checkInInput.addEventListener('change', function() {
            if (checkOutInput.value && new Date(checkInInput.value) >= new Date(checkOutInput.value)) {
                let nextDay = new Date(checkInInput.value);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOutInput.valueAsDate = nextDay;
            }
            calculateTotal();
        });

        checkOutInput.addEventListener('change', calculateTotal);
        roomQtyInput.addEventListener('change', calculateTotal);
        roomQtyInput.addEventListener('input', calculateTotal);
        if (bedTypeInput) {
            bedTypeInput.addEventListener('change', calculateTotal);
        }

        document.querySelectorAll('.menu-qty').forEach(function(input) {
            input.addEventListener('change', calculateTotal);
            input.addEventListener('input', calculateTotal);
        });
        
        // Auto-calculate on load if values are preset
        if(checkInInput.value && checkOutInput.value) {
            calculateTotal();
        }
    });
</script>
</body>
</html>