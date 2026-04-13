<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
        }
        .payment-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            overflow: hidden;
            background: #ffffff;
        }
        .summary-box {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 1px dashed #dee2e6;
        }
        .method-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .method-card:hover {
            border-color: #198754;
            background-color: #f8fff9;
        }
        .method-radio:checked + .method-card {
            border-color: #198754;
            background-color: #f8fff9;
            box-shadow: 0 4px 10px rgba(25, 135, 84, 0.15);
        }
        .method-radio {
            display: none;
        }
        .btn-pay-custom {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 15px rgba(25, 135, 84, 0.3);
            transition: all 0.3s ease;
            color: white;
        }
        .btn-pay-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(25, 135, 84, 0.4);
            color: white;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            @if(session('success'))
                <div class="alert alert-success shadow-sm rounded border-0 border-start border-5 border-success fade show mb-4">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="payment-card">
                <div class="p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-wallet fs-3"></i>
                        </div>
                        <h3 class="fw-bold">Pembayaran</h3>
                        <p class="text-muted">Pilih metode pembayaran untuk menyelesaikan transaksi.</p>
                    </div>

                    <div class="summary-box mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Jenis Layanan</span>
                            <span class="fw-semibold">{{ $type === 'booking' ? 'Pemesanan Kamar' : 'Pesanan Restoran' }}</span>
                        </div>
                        @if($type === 'booking')
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kamar</span>
                            <span class="fw-semibold">{{ $data->room->roomType->name ?? 'Tipe Kamar' }} (No. {{ $data->room->room_number }})</span>
                        </div>
                        @endif
                        <hr class="text-muted my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Pembayaran</span>
                            <h4 class="fw-bold text-success mb-0">Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <form action="{{ route('payment.store') }}" method="POST">
                        @csrf 
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        
                        <h6 class="fw-bold mb-3">Pilih Metode Pembayaran</h6>
                        <div class="row mb-4 g-3">
                            <div class="col-6">
                                <label class="w-100">
                                    <input type="radio" name="payment_method" value="transfer" class="method-radio" required checked>
                                    <div class="method-card p-3 text-center">
                                        <i class="fa-solid fa-building-columns text-primary fs-4 mb-2"></i>
                                        <div class="fw-semibold small">Transfer Bank</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="w-100">
                                    <input type="radio" name="payment_method" value="e_wallet" class="method-radio" required>
                                    <div class="method-card p-3 text-center">
                                        <i class="fa-solid fa-mobile-screen text-info fs-4 mb-2"></i>
                                        <div class="fw-semibold small">E-Wallet</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="w-100">
                                    <input type="radio" name="payment_method" value="credit_card" class="method-radio" required>
                                    <div class="method-card p-3 text-center">
                                        <i class="fa-solid fa-credit-card text-warning fs-4 mb-2"></i>
                                        <div class="fw-semibold small">Kartu Kredit</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="w-100">
                                    <input type="radio" name="payment_method" value="cash" class="method-radio" required>
                                    <div class="method-card p-3 text-center">
                                        <i class="fa-solid fa-money-bill-wave text-success fs-4 mb-2"></i>
                                        <div class="fw-semibold small">Bayar Tunai</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-pay-custom w-100">Konfirmasi Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
