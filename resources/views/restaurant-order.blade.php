<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Makanan - {{ $menu->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="row g-0">
                    <div class="col-md-4 bg-dark">
                        <img src="{{ $menu->foto_url }}" class="img-fluid rounded-start h-100" alt="{{ $menu->name }}" style="object-fit: cover; opacity: 0.8;">
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <h3 class="card-title fw-bold text-success mb-1">{{ $menu->name }}</h3>
                            <p class="text-muted small border-bottom pb-3">{{ $menu->description }}</p>
                            
                            <div class="alert alert-success py-2">
                                <i class="fa-solid fa-tag me-2"></i>Harga Satuan: <strong>Rp {{ number_format($menu->price, 0, ',', '.') }}</strong>
                            </div>

                            <form action="#" method="POST" class="mt-4">
                                @csrf 
                                
                                <h6 class="fw-bold mb-3"><i class="fa-solid fa-user me-2"></i>1. Data Pemesan</h6>
                                <div class="mb-3">
                                    <label class="form-label small">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control form-control-sm" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">No. HP (WhatsApp)</label>
                                        <input type="text" name="phone" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">No. Kamar (Jika Menginap)</label>
                                        <input type="text" name="room_number" class="form-control form-control-sm" placeholder="Contoh: 101">
                                    </div>
                                </div>

                                <h6 class="fw-bold mt-4 mb-3"><i class="fa-solid fa-utensils me-2"></i>2. Detail Pesanan</h6>
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label small">Jumlah Porsi</label>
                                        <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label small">Catatan Tambahan</label>
                                        <input type="text" name="note" class="form-control" placeholder="Contoh: Pedas, jangan pakai daun bawang">
                                    </div>
                                </div>

                                <hr class="mt-4">
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="/#restoran" class="btn btn-light border px-4">Kembali</a>
                                    <button type="submit" class="btn btn-success px-5 fw-bold">Pesan Sekarang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>