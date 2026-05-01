<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke akun Hotelku Anda untuk mengelola pemesanan dan menikmati layanan hotel.">
    <title>Login | Hotelku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --radius-lg: 20px;
            --radius-sm: 10px;
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--navy);
            overflow: hidden;
            position: relative;
        }

        /* Animated background */
        .bg-pattern {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(74, 124, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(201, 168, 76, 0.06) 0%, transparent 40%),
                radial-gradient(circle at 60% 80%, rgba(74, 124, 255, 0.05) 0%, transparent 45%);
        }
        .bg-pattern::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Login Container */
        .login-container {
            position: relative; z-index: 1;
            width: 100%; max-width: 960px;
            margin: 20px;
        }

        .login-card {
            display: flex;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        }

        /* Image Side */
        .login-image-side {
            width: 48%;
            position: relative;
            display: none;
            overflow: hidden;
        }
        @media (min-width: 768px) {
            .login-image-side { display: block; }
        }
        .login-image-side img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 8s ease;
        }
        .login-card:hover .login-image-side img {
            transform: scale(1.05);
        }
        .image-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(10,22,40,0.3) 0%, rgba(10,22,40,0.7) 100%);
            display: flex; flex-direction: column;
            justify-content: flex-end; padding: 40px;
        }
        .image-overlay .brand { font-size: 26px; font-weight: 800; color: white; margin-bottom: 10px; }
        .image-overlay .brand i { color: var(--accent-gold); }
        .image-overlay p { color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.7; }

        /* Form Side */
        .login-form-side {
            width: 100%;
            background: white;
            padding: 48px 40px;
        }
        @media (min-width: 768px) {
            .login-form-side { width: 52%; }
        }

        .form-header {
            margin-bottom: 36px;
        }
        .form-header .welcome-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(74, 124, 255, 0.08);
            color: var(--accent-blue);
            padding: 6px 16px; border-radius: 50px;
            font-size: 12px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 16px;
        }
        .form-header h2 {
            font-size: 28px; font-weight: 800;
            color: var(--navy); margin-bottom: 6px;
        }
        .form-header p {
            color: var(--text-secondary); font-size: 15px;
        }

        /* Form */
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

        .form-check-input:checked {
            background-color: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        /* Buttons */
        .btn-login-main {
            background: linear-gradient(135deg, var(--accent-blue), #3562e3);
            color: white; border: none;
            padding: 16px; border-radius: var(--radius-sm);
            font-weight: 700; font-size: 16px; width: 100%;
            transition: var(--transition);
            box-shadow: 0 8px 25px rgba(74, 124, 255, 0.3);
        }
        .btn-login-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(74, 124, 255, 0.4);
            color: white;
        }

        .link-home {
            color: var(--text-secondary); text-decoration: none;
            font-size: 13px; font-weight: 500;
            transition: var(--transition);
        }
        .link-home:hover { color: var(--accent-blue); }

        .link-register {
            color: var(--accent-blue); text-decoration: none;
            font-weight: 700; transition: var(--transition);
        }
        .link-register:hover { color: #3562e3; }

        /* Alerts */
        .alert-custom-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1.5px solid rgba(239, 68, 68, 0.2);
            border-radius: var(--radius-sm);
            color: #dc2626; padding: 12px 16px;
            font-weight: 500; font-size: 14px;
        }
        .alert-custom-success {
            background: rgba(52, 199, 123, 0.08);
            border: 1.5px solid rgba(52, 199, 123, 0.2);
            border-radius: var(--radius-sm);
            color: #059669; padding: 12px 16px;
            font-weight: 500; font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-image-side">
                <img src="{{ asset('images/login-lobby.png') }}" alt="Hotel Lobby">
                <div class="image-overlay">
                    <div class="brand"><i class="fa-solid fa-hotel me-2"></i>Hotelku</div>
                    <p>Platform reservasi premium untuk pengalaman menginap terbaik. Login untuk mengelola pemesanan Anda.</p>
                </div>
            </div>

            <div class="login-form-side">
                <div class="form-header">
                    <div class="welcome-badge"><i class="fa-solid fa-sparkles"></i> Selamat Datang</div>
                    <h2>Masuk ke Akun</h2>
                    <p>Silakan masuk untuk melanjutkan</p>
                </div>

                @if(session('error'))
                    <div class="alert-custom-error mb-4"><i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert-custom-success mb-4"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
                @endif

                <form action="/login" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label text-muted small" for="remember">Ingat Saya</label>
                        </div>
                        <a href="/" class="link-home"><i class="fa-solid fa-arrow-left me-1"></i>Ke Beranda</a>
                    </div>
                    <button type="submit" class="btn-login-main mb-4">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-muted small mb-0">
                        Belum punya akun? <a href="/register" class="link-register">Daftar Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>