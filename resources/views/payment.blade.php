<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Selesaikan pembayaran pemesanan Anda di Hotelku dengan Midtrans.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran | Hotelku</title>
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

        /* Payment Main */
        .payment-section { padding: 40px 0 80px; }

        .payment-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 40px rgba(0,0,0,0.07);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.04);
            padding: 40px;
        }

        .payment-header {
            text-align: center; margin-bottom: 32px;
        }
        .payment-icon {
            width: 72px; height: 72px; border-radius: 20px;
            display: inline-flex; align-items: center; justify-content: center;
            background: rgba(74, 124, 255, 0.1);
            color: var(--accent-blue); font-size: 28px;
            margin-bottom: 16px;
        }
        .payment-header h3 {
            font-weight: 800; font-size: 24px; color: var(--navy); margin-bottom: 6px;
        }
        .payment-header p {
            font-size: 15px; color: var(--text-secondary);
        }

        /* Summary Box */
        .summary-box {
            background: #f8f9fc;
            border-radius: var(--radius-md);
            padding: 24px;
            border: 1.5px solid #eef0f5;
            margin-bottom: 32px;
        }
        .summary-row {
            display: flex; justify-content: space-between;
            align-items: center; padding: 8px 0;
        }
        .summary-row .label { color: var(--text-secondary); font-size: 14px; font-weight: 500; }
        .summary-row .value { font-weight: 600; font-size: 14px; color: var(--navy); }
        .summary-divider {
            border: none; border-top: 1.5px dashed #e0e3ea; margin: 12px 0;
        }
        .summary-total .label { font-weight: 600; color: var(--navy); font-size: 15px; }
        .summary-total .value {
            font-weight: 800; font-size: 22px; color: var(--success-green);
        }

        /* Midtrans Info */
        .midtrans-info {
            background: linear-gradient(135deg, #f0f4ff, #e8f0fe);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1.5px solid rgba(74, 124, 255, 0.15);
            margin-bottom: 24px;
            text-align: center;
        }
        .midtrans-info .midtrans-logo {
            font-size: 14px;
            font-weight: 700;
            color: var(--accent-blue);
            margin-bottom: 8px;
        }
        .midtrans-info .midtrans-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }
        .midtrans-methods {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 12px;
            flex-wrap: wrap;
        }
        .midtrans-methods .method-badge {
            background: white;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 600;
            color: var(--navy);
            border: 1px solid #e0e3ea;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .midtrans-methods .method-badge i {
            font-size: 14px;
        }

        /* Pay Button */
        .btn-pay {
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            color: var(--navy);
            border: none;
            padding: 16px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 16px;
            width: 100%;
            transition: var(--transition);
            box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3);
            display: flex; align-items: center; justify-content: center; gap: 10px;
            cursor: pointer;
        }
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(201, 168, 76, 0.4);
            color: var(--navy);
        }
        .btn-pay:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .btn-pay .spinner-border {
            width: 20px; height: 20px;
            border-width: 2px;
        }

        /* Alert */
        .alert-success-custom {
            background: rgba(52, 199, 123, 0.08);
            border: 1.5px solid rgba(52, 199, 123, 0.2);
            border-radius: var(--radius-md);
            color: #059669; padding: 14px 20px;
            font-weight: 500; font-size: 14px;
        }
        .alert-error-custom {
            background: rgba(239, 68, 68, 0.08);
            border: 1.5px solid rgba(239, 68, 68, 0.2);
            border-radius: var(--radius-md);
            color: #dc2626; padding: 14px 20px;
            font-weight: 500; font-size: 14px;
        }

        /* Secure Badge */
        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            font-size: 12px;
            color: var(--text-secondary);
        }
        .secure-badge i {
            color: var(--success-green);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .loading-pulse {
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-premium sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
    </div>
</nav>

<!-- Steps -->
<div class="steps-bar">
    <div class="container">
        <ul class="steps-list">
            <li class="step-item done"><span class="step-num"><i class="fa-solid fa-check"></i></span> Pilih Kamar</li>
            <div class="step-divider"></div>
            <li class="step-item done"><span class="step-num"><i class="fa-solid fa-check"></i></span> Isi Data</li>
            <div class="step-divider"></div>
            <li class="step-item active"><span class="step-num">3</span> Pembayaran</li>
        </ul>
    </div>
</div>

<div class="payment-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8" data-aos="fade-up">

                @if(session('success'))
                    <div class="alert-success-custom mb-4">
                        <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <div id="error-alert" class="alert-error-custom mb-4" style="display: none;">
                    <i class="fa-solid fa-exclamation-circle me-2"></i><span id="error-message"></span>
                </div>

                <div class="payment-card">
                    <div class="payment-header">
                        <div class="payment-icon"><i class="fa-solid fa-wallet"></i></div>
                        <h3>Pembayaran</h3>
                        <p>Klik tombol di bawah untuk membayar melalui Midtrans.</p>
                    </div>

                    <div class="summary-box">
                        <div class="summary-row">
                            <span class="label">Jenis Layanan</span>
                            <span class="value">{{ $type === 'booking' ? 'Pemesanan Kamar' : 'Pesanan Restoran' }}</span>
                        </div>
                        @if($type === 'booking')
                        <div class="summary-row">
                            <span class="label">Kamar</span>
                            <span class="value">{{ $data->room->roomType->name ?? 'Tipe Kamar' }} (No. {{ $data->room->room_number }})</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Check-in</span>
                            <span class="value">{{ \Carbon\Carbon::parse($data->check_in)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Check-out</span>
                            <span class="value">{{ \Carbon\Carbon::parse($data->check_out)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Harga Kamar</span>
                            <span class="value">Rp {{ number_format($data->total_price + ($data->discount_amount ?? 0), 0, ',', '.') }}</span>
                        </div>
                        @if(isset($data->discount_amount) && $data->discount_amount > 0)
                        <div class="summary-row" style="color: #10b981;">
                            <span class="label"><i class="fa-solid fa-tags"></i> Potongan Voucher</span>
                            <span class="value">-Rp {{ number_format($data->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if($data->restaurantOrder)
                        <div class="summary-row">
                            <span class="label">Paket Tambahan Restoran</span>
                            <span class="value">Rp {{ number_format($data->restaurantOrder->total_price, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @endif
                        <hr class="summary-divider">
                        <div class="summary-row summary-total">
                            <span class="label">Total Pembayaran</span>
                            <span class="value">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Midtrans Methods Info -->
                    <div class="midtrans-info">
                        <div class="midtrans-logo">
                            <i class="fa-solid fa-shield-halved me-1"></i> Pembayaran Aman via Midtrans
                        </div>
                        <div class="midtrans-desc">
                            Pilih dari berbagai metode pembayaran yang tersedia setelah klik tombol bayar.
                        </div>
                        <div class="midtrans-methods">
                            <span class="method-badge"><i class="fa-solid fa-building-columns"></i> Bank Transfer</span>
                            <span class="method-badge"><i class="fa-solid fa-credit-card"></i> Kartu Kredit</span>
                            <span class="method-badge"><i class="fa-solid fa-mobile-screen"></i> E-Wallet</span>
                            <span class="method-badge"><i class="fa-solid fa-store"></i> Minimarket</span>
                        </div>
                    </div>

                    <button id="btn-pay" class="btn-pay" type="button">
                        <i class="fa-solid fa-lock"></i> Bayar Sekarang — Rp {{ number_format($totalPrice, 0, ',', '.') }}
                    </button>

                    <div class="secure-badge">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Pembayaran dilindungi oleh enkripsi SSL 256-bit</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
@if(config('midtrans.is_production'))
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });

    const payButton = document.getElementById('btn-pay');
    const errorAlert = document.getElementById('error-alert');
    const errorMessage = document.getElementById('error-message');
    const paymentType = '{{ $type }}';
    const paymentId = {{ $data->id }};

    function showError(msg) {
        errorMessage.textContent = msg;
        errorAlert.style.display = 'block';
        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function hideError() {
        errorAlert.style.display = 'none';
    }

    function setLoading(loading) {
        if (loading) {
            payButton.disabled = true;
            payButton.innerHTML = '<span class="spinner-border" role="status"></span> Memproses...';
        } else {
            payButton.disabled = false;
            payButton.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Sekarang — Rp {{ number_format($totalPrice, 0, ",", ".") }}';
        }
    }

    payButton.addEventListener('click', function() {
        hideError();
        setLoading(true);

        // Request Snap Token dari server
        fetch('{{ route("midtrans.token") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                type: paymentType,
                id: paymentId,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.snap_token) {
                // Buka popup Midtrans Snap
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Payment Success:', result);
                        window.location.href = '{{ route("payment.finish") }}?order_id=' + result.order_id + '&status_code=' + result.status_code + '&transaction_status=' + result.transaction_status;
                    },
                    onPending: function(result) {
                        console.log('Payment Pending:', result);
                        window.location.href = '{{ route("payment.finish") }}?order_id=' + result.order_id + '&status_code=' + result.status_code + '&transaction_status=' + result.transaction_status;
                    },
                    onError: function(result) {
                        console.log('Payment Error:', result);
                        setLoading(false);
                        showError('Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                        setLoading(false);
                    }
                });
            } else {
                setLoading(false);
                showError(data.message || 'Gagal membuat token pembayaran.');
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            setLoading(false);
            showError('Terjadi kesalahan jaringan. Silakan coba lagi.');
        });
    });
</script>
</body>
</html>
