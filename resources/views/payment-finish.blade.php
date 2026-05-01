<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran | Hotelku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0a1628;
            --accent-gold: #c9a84c;
            --accent-gold-light: #e4cc7a;
            --accent-blue: #4a7cff;
            --warm-white: #faf9f6;
            --text-secondary: #a0a8b8;
            --success-green: #34c77b;
            --warning-amber: #f59e0b;
            --danger-red: #ef4444;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--warm-white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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

        .finish-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .finish-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 40px rgba(0,0,0,0.07);
            border: 1px solid rgba(0,0,0,0.04);
            padding: 50px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .status-icon {
            width: 100px; height: 100px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 42px;
            margin-bottom: 24px;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }

        .status-icon.success {
            background: rgba(52, 199, 123, 0.12);
            color: var(--success-green);
        }
        .status-icon.pending {
            background: rgba(245, 158, 11, 0.12);
            color: var(--warning-amber);
        }
        .status-icon.failed {
            background: rgba(239, 68, 68, 0.12);
            color: var(--danger-red);
        }

        .finish-card h2 {
            font-weight: 800;
            font-size: 24px;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .finish-card .message {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .order-id {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 10px 16px;
            display: inline-block;
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
            margin: 16px 0 24px;
            border: 1px solid #eef0f5;
        }

        .btn-home {
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            color: var(--navy);
            border: none;
            padding: 14px 32px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3);
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(201, 168, 76, 0.4);
            color: var(--navy);
        }

        .btn-dashboard {
            background: transparent;
            border: 2px solid #eef0f5;
            color: var(--navy);
            padding: 12px 28px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            margin-left: 10px;
        }
        .btn-dashboard:hover {
            background: #f8f9fc;
            border-color: var(--accent-blue);
            color: var(--accent-blue);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .pending .status-icon {
            animation: scaleIn 0.5s ease-out, pulse 2s ease-in-out infinite 0.5s;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-premium">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fa-solid fa-hotel me-2"></i>Hotelku</a>
    </div>
</nav>

<div class="finish-section {{ $status }}">
    <div class="finish-card" data-aos="zoom-in" data-aos-duration="500">
        @if($status === 'success')
            <div class="status-icon success">
                <i class="fa-solid fa-check"></i>
            </div>
            <h2>Pembayaran Berhasil!</h2>
            <p class="message">{{ $message }}</p>
        @elseif($status === 'pending')
            <div class="status-icon pending">
                <i class="fa-solid fa-clock"></i>
            </div>
            <h2>Menunggu Pembayaran</h2>
            <p class="message">{{ $message }}</p>
            <p class="message">Silakan selesaikan pembayaran sesuai instruksi yang diberikan. Status akan diperbarui otomatis.</p>
        @else
            <div class="status-icon failed">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <h2>Pembayaran Gagal</h2>
            <p class="message">{{ $message }}</p>
        @endif

        @if($orderId)
            <div class="order-id">
                <i class="fa-solid fa-receipt me-1"></i> Order ID: {{ $orderId }}
            </div>
        @endif

        <div>
            <a href="/" class="btn-home">
                <i class="fa-solid fa-home"></i> Kembali ke Beranda
            </a>
            <a href="{{ route('dashboard') }}" class="btn-dashboard">
                <i class="fa-solid fa-list"></i> Pesanan Saya
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });</script>
</body>
</html>
