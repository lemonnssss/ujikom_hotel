<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking - {{ $roomType->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Form Pemesanan: {{ $roomType->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        Harga per malam: <strong>Rp {{ number_format($roomType->price, 0, ',', '.') }}</strong>
                    </div>

                    <form action="#" method="POST">
                        @csrf 
                        
                        <h5 class="mb-3 border-bottom pb-2">1. Data Tamu</h5>
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>No. HP (WhatsApp)</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 border-bottom pb-2">2. Detail Menginap</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Check-In</label>
                                <input type="date" name="check_in" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Check-Out</label>
                                <input type="date" name="check_out" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-4 text-uppercase fw-bold">Konfirmasi Pesanan</button>
                        <a href="/" class="btn btn-outline-secondary w-100 mt-2">Batal & Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>