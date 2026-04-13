<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking - {{ $roomType->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
        }
        .booking-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            overflow: hidden;
            background: #ffffff;
            transition: transform 0.3s ease;
        }
        .booking-card:hover {
            transform: translateY(-5px);
        }
        .card-header-custom {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            color: white;
            padding: 25px 30px;
            border-bottom: none;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.25);
            border-color: #198754;
            background-color: #fff;
        }
        .btn-success-custom {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 15px rgba(25, 135, 84, 0.3);
            transition: all 0.3s ease;
        }
        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(25, 135, 84, 0.4);
            color: white;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 600;
            color: #212529;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #198754;
            border-radius: 2px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            @if(session('error'))
                <div class="alert alert-danger shadow-sm rounded border-0 border-start border-5 border-danger fade show mb-4">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="booking-card">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1 fw-bold">Konfirmasi Pemesanan</h3>
                        <p class="mb-0 text-white-50"><i class="fa-solid fa-bed me-2"></i> {{ $roomType->name }}</p>
                    </div>
                    <div class="text-end">
                        <span class="d-block small text-white-50">Harga per malam</span>
                        <h4 class="mb-0 fw-bold">Rp {{ number_format($roomType->price, 0, ',', '.') }}</h4>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('booking.store', $roomType->id) }}" method="POST">
                        @csrf 
                        
                        <h5 class="section-title"><i class="fa-solid fa-user-circle me-2 text-success"></i> Informasi Tamu</h5>
                        <div class="mb-4">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-user text-muted"></i></span>
                                <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="email@contoh.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-brands fa-whatsapp text-muted"></i></span>
                                    <input type="text" name="phone" class="form-control border-start-0 ps-0" placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label">NIK (Nomor KTP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-id-card text-muted"></i></span>
                                    <input type="text" name="identity_number" class="form-control border-start-0 ps-0" placeholder="16 Digit NIK" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-map-location-dot text-muted"></i></span>
                                    <input type="text" name="address" class="form-control border-start-0 ps-0" placeholder="Jl. Contoh No. 123" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title mt-5"><i class="fa-solid fa-calendar-alt me-2 text-success"></i> Detail Jadwal</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label">Tanggal Check-In</label>
                                <input type="date" name="check_in" id="check_in" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Check-Out</label>
                                <input type="date" name="check_out" id="check_out" class="form-control" required>
                            </div>
                        </div>

                        <!-- Ringkasan Harga Dinamis -->
                        <div class="alert bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 d-flex justify-content-between align-items-center mb-4 mt-4" id="price-summary-container" style="display: none !important;">
                            <div>
                                <h6 class="mb-1 fw-bold text-success"><i class="fa-solid fa-receipt me-2"></i>Total Pembayaran</h6>
                                <p class="mb-0 small text-muted" id="price-details"><span id="days-count">0</span> malam x Rp {{ number_format($roomType->price, 0, ',', '.') }}</p>
                            </div>
                            <h4 class="mb-0 fw-bold text-success" id="total-price-display">Rp 0</h4>
                        </div>
                        
                        <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                            <a href="/" class="btn btn-light py-3 px-4 rounded-3 text-secondary fw-semibold border w-100"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
                            <button type="submit" class="btn btn-success-custom w-100"><i class="fa-solid fa-check-circle me-2"></i> Selesaikan Pemesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const pricePerNight = {{ $roomType->price }};
        const summaryContainer = document.getElementById('price-summary-container');
        const daysCountSpan = document.getElementById('days-count');
        const totalPriceDisplay = document.getElementById('total-price-display');

        function calculateTotal() {
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);

            if (checkInInput.value && checkOutInput.value && checkOutDate > checkInDate) {
                // Remove the "display: none !important" inline style
                summaryContainer.style.setProperty('display', 'flex', 'important'); 

                const diffTime = Math.abs(checkOutDate - checkInDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                
                daysCountSpan.textContent = diffDays;
                
                const totalPrice = diffDays * pricePerNight;
                totalPriceDisplay.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            } else {
                summaryContainer.style.setProperty('display', 'none', 'important');
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
    });
</script>
</body>
</html>