<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Premium Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .register-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-direction: row-reverse;
        }
        .register-image {
            background: url('https://images.unsplash.com/photo-1542314831-c6a4d14d8c53?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') center/cover;
            width: 50%;
            display: none;
        }
        @media (min-width: 768px) {
            .register-image { display: block; }
        }
        .register-form-container {
            width: 100%;
            padding: 3rem;
        }
        @media (min-width: 768px) {
            .register-form-container { width: 50%; }
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #3264ff;
            background-color: #fff;
        }
        .btn-primary {
            background: #3264ff;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #234bcc;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(50, 100, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center p-3">
        <div class="register-card">
            <div class="register-image"></div>
            <div class="register-form-container">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark mb-2">Buat Akun Baru</h2>
                    <p class="text-muted">Bergabunglah untuk pengalaman menginap terbaik</p>
                </div>
                
                <form action="/register" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-4">Daftar Sekarang</button>
                </form>
                
                <div class="text-center d-flex justify-content-between">
                    <a href="/" class="text-muted small text-decoration-none">← Kembali</a>
                    <p class="text-muted small mb-0">Sudah punya akun? <a href="/login" class="text-primary fw-bold text-decoration-none">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>