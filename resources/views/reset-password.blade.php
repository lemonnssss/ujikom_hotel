<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kata Sandi Baru | Hotelku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #0a1628;
            --accent-gold: #c9a84c;
            --accent-gold-light: #e4cc7a;
            --text-secondary: #a0a8b8;
            --radius-lg: 20px;
            --radius-sm: 10px;
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

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

        .bg-pattern {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(circle at 80% 50%, rgba(201, 168, 76, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 20% 30%, rgba(74, 124, 255, 0.06) 0%, transparent 40%);
        }

        .verify-container {
            position: relative; z-index: 1;
            width: 100%; max-width: 450px;
            margin: 20px;
            background: white;
            padding: 48px 40px;
            border-radius: var(--radius-lg);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .form-header { margin-bottom: 32px; }
        .form-header i { font-size: 48px; color: var(--accent-gold); margin-bottom: 16px; }
        .form-header h2 { font-size: 24px; font-weight: 800; color: var(--navy); margin-bottom: 6px; }
        .form-header p { color: var(--text-secondary); font-size: 15px; }

        .form-control {
            border: 2px solid #eef0f5;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-weight: 500; font-size: 15px;
            transition: var(--transition);
            background: #f8f9fc;
        }
        .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.15);
            background: white;
        }

        .btn-main {
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-gold-light));
            color: var(--navy); border: none;
            padding: 16px; border-radius: var(--radius-sm);
            font-weight: 700; font-size: 16px; width: 100%;
            transition: var(--transition);
            box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3);
            margin-top: 16px;
        }
        .btn-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(201, 168, 76, 0.4);
            color: var(--navy);
        }

        .password-hint {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: var(--text-secondary);
            margin-top: 6px; text-align: left;
        }
        .password-hint i { color: var(--accent-gold); font-size: 10px; }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>

    <div class="verify-container">
        <div class="form-header">
            <i class="fa-solid fa-lock"></i>
            <h2>Buat Kata Sandi Baru</h2>
            <p>Silakan masukkan kata sandi baru Anda.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="border-radius: var(--radius-sm); font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius: var(--radius-sm); font-size: 14px;">
                <ul class="mb-0 text-start">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/reset-password" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label fw-bold text-uppercase" style="font-size: 12px; color: #5a6577;">Kata Sandi Baru</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                <div class="password-hint"><i class="fa-solid fa-circle"></i> Minimal 6 karakter</div>
            </div>
            <div class="mb-4 text-start">
                <label class="form-label fw-bold text-uppercase" style="font-size: 12px; color: #5a6577;">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-main">
                Simpan Kata Sandi Baru
            </button>
        </form>
    </div>
</body>
</html>
