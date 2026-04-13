<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Makanan - {{ $menu->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
        }
        .order-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            overflow: hidden;
            background: #ffffff;
            transition: transform 0.3s ease;
        }
        .order-card:hover {
            transform: translateY(-5px);
        }
        .img-container {
            position: relative;
            height: 100%;
            min-height: 300px;
        }
        .img-container img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        .price-badge {
            background: linear-gradient(135deg, #fd7e14 0%, #e8590c 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(232, 89, 12, 0.3);
        }
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(253, 126, 20, 0.25);
            border-color: #fd7e14;
            background-color: #fff;
        }
        .btn-order-custom {
            background: linear-gradient(135deg, #fd7e14 0%, #e8590c 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 15px rgba(253, 126, 20, 0.3);
            transition: all 0.3s ease;
        }
        .btn-order-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(253, 126, 20, 0.4);
            color: white;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #212529;
            font-size: 1.1rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: #fd7e14;
            border-radius: 2px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            @if(session('error'))
                <div class="alert alert-danger shadow-sm rounded border-0 border-start border-5 border-danger fade show mb-4">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="order-card">
                <div class="row g-0">
                    <div class="col-md-5 img-container d-none d-md-block">
                        <img src="{{ $menu->foto_url }}" alt="{{ $menu->name }}">
                    </div>
                    
                    <div class="col-md-7">
                        <div class="p-4 p-md-5">
                            
                            <!-- Header Info -->
                            <div class="mb-4">
                                <h2 class="fw-bold text-dark mb-2">{{ $menu->name }}</h2>
                                <p class="text-muted lh-base mb-3">{{ $menu->description }}</p>
                                <div class="price-badge">
                                    <i class="fa-solid fa-tag me-2"></i> Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </div>
                            </div>
                            
                            <form action="{{ route('restaurant.store', $menu->id) }}" method="POST">
                                @csrf 
                                
                                <h5 class="section-title"><i class="fa-solid fa-user me-2" style="color: #fd7e14;"></i> Informasi Pemesan</h5>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-user text-muted"></i></span>
                                        <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="Masukkan nama Anda" required>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label">Nomor WhatsApp</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-brands fa-whatsapp text-muted"></i></span>
                                            <input type="text" name="phone" class="form-control border-start-0 ps-0" placeholder="08xxxxxxxxxx" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. Kamar (Opsional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-door-closed text-muted"></i></span>
                                            <input type="text" name="room_number" class="form-control border-start-0 ps-0" placeholder="Mis. 101">
                                        </div>
                                    </div>
                                </div>

                                <h5 class="section-title mt-4"><i class="fa-solid fa-utensils me-2" style="color: #fd7e14;"></i> Detail Pesanan</h5>
                                <div class="row mb-4 align-items-start">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label class="form-label">Jumlah Porsi</label>
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                                            <span class="input-group-text bg-light">Porsi</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Catatan Tambahan (Opsional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-comment-dots text-muted"></i></span>
                                            <input type="text" name="note" class="form-control border-start-0 ps-0" placeholder="Mis. Pedas, tanpa daun bawang...">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-md-row gap-3 mt-5">
                                    <a href="/#restoran" class="btn btn-light py-3 px-4 rounded-3 text-secondary fw-semibold border w-100"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
                                    <button type="submit" class="btn btn-order-custom w-100"><i class="fa-solid fa-cart-check me-2"></i> Pesan Sekarang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>