<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hotelku</title>
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #3264ff;
            --primary-light: #eff3ff;
            --secondary: #1e293b;
            --bg-color: #f8fafc;
            --sidebar-bg: #0f172a;
            --font-family: 'Outfit', sans-serif;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: #334155;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: #94a3b8;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-menu {
            padding: 1.5rem 1rem;
            flex-grow: 1;
        }

        .nav-item-btn {
            width: 100%;
            text-align: left;
            background: transparent;
            border: none;
            color: #94a3b8;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }

        .nav-item-btn:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }

        .nav-item-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(50,100,255,0.3);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }
        
        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-area {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Generic UI Elements */
        .card-custom {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .stat-card {
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 16px;
            color: white;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: rgba(255,255,255,0.2);
        }

        .table-custom {
            margin-bottom: 0;
        }
        .table-custom th {
            background: #f8fafc;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .table-custom td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge-soft {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .user-dropdown {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.5rem;
            min-width: 200px;
        }

        /* Client specific */
        .client-navbar {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* Mobile toggle button */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #334155;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            cursor: pointer;
        }
        .sidebar-toggle:hover {
            background: #f1f5f9;
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active {
            display: block;
        }

        /* Mobile Nav Menu Scrollable */
        .nav-menu {
            overflow-y: auto;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1050;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: inline-flex;
            }
            .topbar {
                padding: 0.75rem 1rem;
            }
            .content-area {
                padding: 1rem;
            }
            .stat-card {
                padding: 1.25rem;
            }
            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.2rem;
            }
            .stat-card h3 {
                font-size: 1.25rem;
            }
            .table-custom th, .table-custom td {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
            }
            .card-custom .px-4 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }

        @media (max-width: 767.98px) {
            .table-custom thead {
                display: none;
            }
            .table-custom tbody, .table-custom tr, .table-custom td {
                display: block;
                width: 100%;
            }
            .table-custom tbody {
                padding: 0.5rem;
            }
            .table-custom tr {
                margin-bottom: 1.5rem;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                background: #ffffff;
                box-shadow: 0 8px 24px rgba(149, 157, 165, 0.1);
                transition: transform 0.2s;
            }
            .table-custom tr:hover {
                transform: translateY(-2px);
            }
            .table-custom td {
                text-align: left !important;
                padding: 1rem 1.25rem !important;
                border-bottom: 1px solid #f1f5f9;
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            .table-custom td:last-child {
                border-bottom: none;
                background-color: #f8fafc;
                border-radius: 0 0 16px 16px;
                align-items: flex-end;
            }
            .table-custom td:last-child .d-flex {
                width: 100%;
                justify-content: flex-end !important;
            }
            .table-custom td:last-child::before {
                display: none; /* Sembunyikan label untuk kolom aksi */
            }
            /* Tampilkan label dari atribut data-label sebelum konten sel */
            .table-custom td::before {
                content: attr(data-label);
                display: block;
                width: 100%;
                font-weight: 700;
                font-size: 0.65rem;
                color: #94a3b8;
                text-transform: uppercase;
                margin-bottom: 0.25rem;
                letter-spacing: 1px;
            }
        }

        @media (max-width: 575.98px) {
            .topbar {
                gap: 0.5rem;
            }
            .topbar h5 {
                font-size: 0.9rem;
                display: none; /* Sembunyikan text Dasbor Admin di mobile agar select fit */
            }
            .topbar .d-flex {
                gap: 0.5rem !important;
            }
            .topbar .form-select {
                min-width: 110px !important;
                max-width: 140px;
                font-size: 0.75rem !important;
                text-overflow: ellipsis;
            }
            .card-custom .border-bottom.d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }
            .card-custom .border-bottom.d-flex > div,
            .card-custom .border-bottom.d-flex > button {
                width: 100%;
                justify-content: flex-start !important;
            }
            .card-custom .border-bottom.d-flex .d-flex {
                flex-direction: column;
                width: 100% !important;
            }
            .stat-card h3 {
                font-size: 1.1rem;
            }
            .stat-card p {
                font-size: 0.65rem !important;
            }
        }
    </style>
</head>
<body>

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
    <!-- ADMIN SIDEBAR -->
    <div class="sidebar shadow-lg">
        <div class="sidebar-header">
            <a href="/" class="sidebar-brand text-decoration-none">
                <i class="fa-solid fa-hotel text-primary fs-3"></i>
                <span class="fs-4 fw-bolder text-white">Hotelku</span>
            </a>
        </div>
        
        <div class="nav-menu" role="tablist">
            <p class="text-xs fw-bold text-uppercase mb-3 px-3" style="color: #64748b; letter-spacing: 1px;">Manajemen</p>
            <button class="nav-item-btn active" data-bs-toggle="pill" data-bs-target="#tab-statistics">
                <i class="fa-solid fa-chart-pie w-20px text-center"></i> Statistik & Laporan
            </button>
            @if(Auth::user()->role == 'admin')
            <button class="nav-item-btn" data-bs-toggle="pill" data-bs-target="#tab-hotels-list">
                <i class="fa-solid fa-building w-20px text-center"></i> Kelola Cabang Hotel
            </button>
            @endif
            <button class="nav-item-btn" data-bs-toggle="pill" data-bs-target="#tab-hotel">
                <i class="fa-solid fa-bed w-20px text-center"></i> Kamar & Lokasi
            </button>
            @if(Auth::user()->role == 'admin')
            <button class="nav-item-btn" data-bs-toggle="pill" data-bs-target="#tab-resto">
                <i class="fa-solid fa-utensils w-20px text-center"></i> Menu Restoran
            </button>
            @endif
            <button class="nav-item-btn" data-bs-toggle="pill" data-bs-target="#tab-stock">
                <i class="fa-solid fa-door-open w-20px text-center"></i> Status Kamar
            </button>
            <button class="nav-item-btn" data-bs-toggle="pill" data-bs-target="#tab-bookings">
                <i class="fa-solid fa-calendar-check w-20px text-center"></i> Data Reservasi
            </button>
            @if(Auth::user()->role == 'admin')
            <button class="nav-item-btn" data-bs-toggle="pill" data-bs-target="#tab-users">
                <i class="fa-solid fa-users w-20px text-center"></i> Data Pengguna
            </button>
            <button class="nav-item-btn" data-bs-toggle="pill" data-bs-target="#tab-vouchers">
                <i class="fa-solid fa-ticket w-20px text-center"></i> Kelola Voucher
            </button>
            @endif
        </div>
        
        <div class="p-4 border-top border-secondary border-opacity-10">
            <div class="d-flex align-items-center gap-3 w-100" role="button" data-bs-toggle="modal" data-bs-target="#profileModal" style="cursor: pointer; transition: all 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                @if(Auth::user()->foto_profil)
                <img src="{{ Storage::url(Auth::user()->foto_profil) }}" width="40" height="40" class="rounded-circle shadow-sm" style="object-fit:cover;">
                @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3264ff&color=fff" width="40" height="40" class="rounded-circle shadow-sm">
                @endif
                <div class="flex-grow-1">
                    <h6 class="mb-0 text-white fw-semibold small">{{ Auth::user()->name }}</h6>
                    <span class="text-white-50 small" style="font-size: 0.7rem;">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
                <i class="fa-solid fa-pen-to-square text-white-50" style="font-size: 0.85rem;"></i>
            </div>
        </div>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="fw-bold mb-0 text-dark">Dasbor Admin</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if(Auth::user()->role == 'admin')
                <form action="" method="GET" class="m-0" title="Filter Data Berdasarkan Cabang Hotel">
                    <select name="hotel" onchange="this.form.submit()" class="form-select form-select-sm border-0 bg-light shadow-sm text-primary" style="min-width: 180px; font-weight: 600;">
                        <option value="">-- Semua Cabang Hotel --</option>
                        @foreach($hotelsList as $h)
                            <option value="{{ $h }}" {{ $selectedHotel == $h ? 'selected' : '' }}>Hotelku {{ $h }}</option>
                        @endforeach
                    </select>
                </form>
                @else
                <span class="badge bg-primary text-white px-3 py-2 shadow-sm rounded-pill"><i class="fa-solid fa-building me-1"></i> Cabang: {{ str_replace('_', ' ', $selectedHotel) }}</span>
                @endif
                
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle shadow-sm p-2" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-bars text-secondary px-1"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown shadow-lg">
                        <li><a class="dropdown-item py-2" href="/"><i class="fa-solid fa-home me-2 text-primary"></i> Kembali ke Beranda</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger fw-semibold" href="/logout"><i class="fa-solid fa-sign-out-alt me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4 d-flex align-items-center" role="alert">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; flex-shrink: 0;"><i class="fa-solid fa-check small"></i></div>
                    <span class="fw-medium">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4 d-flex align-items-center" role="alert">
                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; flex-shrink: 0;"><i class="fa-solid fa-exclamation small"></i></div>
                    <span class="fw-medium">{{ $errors->first() }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4 d-flex align-items-center" role="alert">
                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; flex-shrink: 0;"><i class="fa-solid fa-exclamation small"></i></div>
                    <span class="fw-medium">{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif



            <!-- TAB CONTENTS -->
            <div class="tab-content" id="pills-tabContent">
                
                <!-- TAB STATISTIK -->
                <div class="tab-pane fade show active" id="tab-statistics">
                    <!-- Stats Row -->
                    <div class="row g-4 mb-4 justify-content-center">
                        <div class="col-md-4">
                            <div class="stat-card bg-primary shadow-sm">
                                <div>
                                    <p class="text-white-50 small fw-bold mb-1">TOTAL PENDAPATAN</p>
                                    <h3 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                                </div>
                                <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card" style="background: #10b981; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);">
                                <div>
                                    <p class="text-white-50 small fw-bold mb-1">TOTAL TRANSAKSI</p>
                                    <h3 class="fw-bold mb-0">{{ $totalBookings }}</h3>
                                </div>
                                <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card" style="background: #f59e0b; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);">
                                <div>
                                    <p class="text-white-50 small fw-bold mb-1">KAMAR TERISI</p>
                                    <h3 class="fw-bold mb-0">{{ $occupiedRoomsCount }}</h3>
                                </div>
                                <div class="stat-icon"><i class="fa-solid fa-bed"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Row -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card-custom">
                                <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded"><i class="fa-solid fa-chart-line"></i></div>
                                        Grafik Pendapatan {{ date('Y') }}
                                    </h6>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('dashboard.report') }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-file-pdf"></i> Unduh Laporan PDF</a>
                                        @if(Auth::user()->role == 'admin')
                                        <form action="{{ route('dashboard.reset_revenue') }}" method="POST" onsubmit="return confirm('Yakin ingin mereset semua pendapatan menjadi 0? Histori pembayaran akan dihapus namun histori booking tetap ada.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-rotate-left"></i> Reset Pendapatan</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-4">
                                    <canvas id="revenueChart" height="80"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(Auth::user()->role == 'admin')
                <!-- TAB HOTELS (ADMIN ONLY) -->
                <div class="tab-pane fade" id="tab-hotels-list">
                    <div class="card-custom">
                        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded"><i class="fa-solid fa-building"></i></div>
                                Daftar Cabang Hotel Resmi
                            </h6>
                            <button class="btn btn-primary fw-semibold d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addHotelModal">
                                <i class="fa-solid fa-plus"></i> Tambah Cabang
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead><tr><th class="ps-4">Cabang Hotel</th><th>Key Mapping</th><th>Manager</th><th class="text-end">Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($hotelsData as $htl)
                                    <tr>
                                        <td data-label="Cabang Hotel" class="ps-4 fw-bold text-dark">{{ $htl->name }}</td>
                                        <td data-label="Key Mapping"><span class="badge badge-soft bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $htl->location_key }}</span></td>
                                        <td data-label="Manager">
                                            @if($htl->owner)
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-user-tie text-muted"></i> <span class="fw-medium text-dark">{{ $htl->owner->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted small"><i class="fa-solid fa-exclamation-circle text-warning me-1"></i>Belum Ada Manager</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editHotel{{ $htl->id }}"><i class="fa-solid fa-pen"></i></button>
                                                <a href="/dashboard/hotel/delete/{{ $htl->id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus cabang hotel ini?')"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- TAB KAMAR -->
                <div class="tab-pane fade {{ Auth::user()->role == 'manager' ? 'show active' : '' }}" id="tab-hotel">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="card-custom">
                                <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded"><i class="fa-solid fa-bed"></i></div>
                                        Daftar Tipe Kamar
                                    </h6>
                                    <div class="d-flex w-50 gap-3 justify-content-end">
                                        <form action="" method="GET" class="d-flex w-100">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
                                                <input type="text" name="search_room" class="form-control bg-light border-0" placeholder="Cari nama kamar...">
                                            </div>
                                        </form>
                                        <button class="btn btn-primary fw-semibold d-flex align-items-center gap-2 shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                                            <i class="fa-solid fa-plus"></i> Tambah Tipe
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-custom table-hover">
                                        <thead><tr><th>Informasi Kamar</th><th>Lokasi</th><th>Harga</th><th class="text-end">Aksi</th></tr></thead>
                                        <tbody>
                                            @foreach($rooms as $room)
                                    <tr>
                                        <td data-label="Informasi Kamar">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ Str::startsWith($room->foto_url, 'http') ? $room->foto_url : asset('storage/' . $room->foto_url) }}" class="rounded-3 shadow-sm object-fit-cover" style="width: 60px; height: 60px;">
                                                <div>
                                                    <h6 class="mb-1 fw-bold text-dark">{{ $room->name }}</h6>
                                                    <p class="mb-0 text-muted small text-truncate" style="max-width: 180px;">{{ $room->description }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Lokasi"><span class="badge badge-soft bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $room->location ?? 'Umum' }}</span></td>
                                        <td data-label="Harga" class="fw-bold text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                                        <td data-label="Aksi" class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editRoom{{ $room->id }}"><i class="fa-solid fa-pen"></i></button>
                                                <a href="/dashboard/kamar/delete/{{ $room->id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus tipe kamar ini?')"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB MENU -->
                <div class="tab-pane fade" id="tab-resto">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="card-custom">
                                <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                        <div class="bg-success bg-opacity-10 text-success p-2 rounded"><i class="fa-solid fa-utensils"></i></div>
                                        Daftar Menu Restoran
                                    </h6>
                                    <div class="d-flex w-50 gap-3 justify-content-end">
                                        <form action="" method="GET" class="d-flex w-100">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
                                                <input type="text" name="search_menu" class="form-control bg-light border-0" placeholder="Cari menu...">
                                            </div>
                                        </form>
                                        <button class="btn btn-success fw-semibold d-flex align-items-center gap-2 shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                                            <i class="fa-solid fa-plus"></i> Tambah Menu
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-custom table-hover">
                                        <thead><tr><th>Menu</th><th>Harga</th><th class="text-end">Aksi</th></tr></thead>
                                        <tbody>
                                            @foreach($menus as $menu)
                                            <tr>
                                                <td data-label="Menu">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ Str::startsWith($menu->foto_url, 'http') ? $menu->foto_url : asset('storage/' . $menu->foto_url) }}" class="rounded-3 shadow-sm object-fit-cover" style="width: 60px; height: 60px;">
                                                        <div>
                                                            <h6 class="mb-1 fw-bold text-dark">{{ $menu->name }}</h6>
                                                            <p class="mb-0 text-muted small text-truncate" style="max-width: 250px;">{{ $menu->description }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="Harga" class="fw-bold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMenu{{ $menu->id }}"><i class="fa-solid fa-pen"></i></button>
                                                        <a href="/dashboard/menu/delete/{{ $menu->id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus menu ini?')"><i class="fa-solid fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB STATUS KAMAR -->
                <div class="tab-pane fade" id="tab-stock">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="card-custom">
                                <div class="px-4 py-3 border-bottom d-flex align-items-center gap-2">
                                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded"><i class="fa-solid fa-door-open"></i></div>
                                    <h6 class="fw-bold mb-0">Tambah Fisik Kamar</h6>
                                </div>
                                <div class="p-4">
                                    <form action="/dashboard/room-item" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Pilih Tipe Kamar</label>
                                            <select name="room_type_id" class="form-select bg-light" required>
                                                <option value="">-- Pilih Tipe --</option>
                                                @foreach($rooms as $rt)
                                                    <option value="{{ $rt->id }}">{{ $rt->name }} - Rp {{ number_format($rt->price, 0, ',', '.') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Nomor Kamar</label>
                                            <input type="text" name="room_number" class="form-control" placeholder="Contoh: 101, 203" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label small fw-semibold">Status Awal</label>
                                            <select name="status" class="form-select bg-light" required>
                                                <option value="available">Tersedia (Available)</option>
                                                <option value="occupied">Terisi (Occupied)</option>
                                                <option value="maintenance">Perawatan (Maintenance)</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-warning w-100 fw-bold py-2 rounded-3 text-dark">Simpan Nomor Kamar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card-custom">
                                <div class="px-4 py-3 border-bottom">
                                    <h6 class="fw-bold mb-0 text-dark">Manajemen Ketersediaan Nomor Kamar</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-custom table-hover">
                                        <thead><tr><th>No. Kamar</th><th>Kategori Tipe</th><th>Status</th><th class="text-end">Ubah Aksi</th></tr></thead>
                                        <tbody>
                                            @foreach($allRooms as $r)
                                            <tr>
                                                <td><span class="fw-bold text-primary fs-5">{{ $r->room_number }}</span></td>
                                                <td>
                                                    <div class="fw-semibold text-dark">{{ $r->roomType->name ?? '-' }}</div>
                                                    <div class="small text-muted">Cabang {{ $r->roomType->location ?? 'Pusat' }}</div>
                                                </td>
                                                <td>
                                                    @if($r->status == 'available') <span class="badge badge-soft bg-success bg-opacity-10 text-success border border-success border-opacity-25"><i class="fa-solid fa-check-circle me-1"></i>Tersedia</span>
                                                    @elseif($r->status == 'occupied') <span class="badge badge-soft bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25"><i class="fa-solid fa-user-lock me-1"></i>Terisi</span>
                                                    @else <span class="badge badge-soft bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25"><i class="fa-solid fa-wrench me-1"></i>Perbaikan</span> @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                                        <form action="/dashboard/room-item/update/{{ $r->id }}" method="POST" class="m-0">
                                                            @csrf
                                                            <select name="status" class="form-select form-select-sm shadow-sm" onchange="this.form.submit()" style="min-width: 130px; border-radius: 8px;">
                                                                <option value="available" {{ $r->status == 'available' ? 'selected' : '' }}>Available</option>
                                                                <option value="occupied" {{ $r->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                                                <option value="maintenance" {{ $r->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                            </select>
                                                        </form>
                                                        <a href="/dashboard/room-item/delete/{{ $r->id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus nomor kamar ini?')"><i class="fa-solid fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB RESERVASI -->
                <div class="tab-pane fade" id="tab-bookings">
                    <div class="card-custom">
                        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded"><i class="fa-solid fa-calendar-check"></i></div>
                                Daftar Reservasi Tamu
                            </h6>
                            <button class="btn btn-primary fw-semibold d-flex align-items-center gap-2 shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#addManualBookingModal">
                                <i class="fa-solid fa-user-plus"></i> Reservasi Manual (Walk-in)
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead><tr><th>Info Tamu</th><th>Detail Kamar / Tgl</th><th>Total Tagihan</th><th>Pembayaran</th><th class="text-end">Status & Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($allBookings as $b)
                                    <tr>
                                        <td data-label="Info Tamu">
                                            <div class="fw-bold text-dark">{{ $b->guest->name ?? '-' }}</div>
                                            <div class="small text-muted">{{ $b->guest->email ?? '-' }}</div>
                                        </td>
                                        <td data-label="Detail Kamar / Tgl">
                                            <div class="fw-semibold text-primary">{{ $b->rooms->first()->roomType->name ?? '-' }} <span class="badge bg-secondary ms-1"> {{ $b->room_qty }} Kamar</span></div>
                                            <div class="small text-muted mb-1">No: {{ $b->rooms->pluck('room_number')->implode(', ') }}</div>
                                            <div class="small text-muted">Cabang {{ $b->rooms->first()->roomType->location ?? 'Pusat' }}</div>
                                            <div class="small text-muted mt-1"><i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($b->check_in)->format('d M') }} - {{ \Carbon\Carbon::parse($b->check_out)->format('d M') }}</div>
                                        </td>
                                        <td data-label="Total Tagihan" class="fw-bold text-dark">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                                        <td data-label="Pembayaran">
                                            @if($b->payments->where('payment_status', 'paid')->count() > 0)
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge badge-soft bg-success text-white px-3"><i class="fa-solid fa-check me-1"></i>PAID</span>
                                                    <a href="{{ route('booking.invoice', $b->id) }}" target="_blank" class="btn btn-sm btn-outline-success py-0 px-2 rounded-2" title="Unduh Invoice PDF"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                                                </div>
                                            @else
                                                <span class="badge badge-soft bg-danger text-white px-3"><i class="fa-solid fa-clock me-1"></i>PENDING</span>
                                            @endif
                                        </td>
                                        <td data-label="Status & Aksi" class="text-end">
                                            @if($b->status == 'pending')
                                                <div class="d-flex justify-content-end gap-2">
                                                    <form action="/dashboard/booking/{{ $b->id }}/status" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="action" value="verify_payment">
                                                        <button class="btn btn-sm btn-success fw-semibold"><i class="fa-solid fa-money-check-dollar me-1"></i>Verifikasi</button>
                                                    </form>
                                                    <form action="/dashboard/booking/{{ $b->id }}/status" method="POST" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="action" value="cancel">
                                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Batalkan booking secara sepihak?')"><i class="fa-solid fa-times"></i></button>
                                                    </form>
                                                </div>
                                            @elseif($b->status == 'confirmed')
                                                <form action="/dashboard/booking/{{ $b->id }}/status" method="POST" class="m-0 d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="check_in">
                                                    <button class="btn btn-sm btn-primary fw-semibold px-3"><i class="fa-solid fa-sign-in-alt me-1"></i>Check-In Tamu</button>
                                                </form>
                                            @elseif($b->status == 'checked_in')
                                                <form action="/dashboard/booking/{{ $b->id }}/status" method="POST" class="m-0 d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="check_out">
                                                    <button class="btn btn-sm btn-warning fw-bold px-3 text-dark"><i class="fa-solid fa-sign-out-alt me-1"></i>Selesaikan (Check-Out)</button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary text-uppercase py-2 px-3">{{ str_replace('_', ' ', $b->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB PENGGUNA -->
                <div class="tab-pane fade" id="tab-users">
                    <div class="card-custom">
                        <div class="px-4 py-3 border-bottom">
                            <h6 class="fw-bold mb-0 text-dark">Kelola Pengguna Sistem</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead><tr><th class="ps-4">Profil User</th><th>Email</th><th>Tgl Terdaftar</th><th class="text-end">Atur Role & Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($users as $usr)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($usr->name) }}&background=random&color=fff" width="40" height="40" class="rounded-circle shadow-sm">
                                                <div class="fw-bold text-dark">{{ $usr->name }}</div>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $usr->email }}</td>
                                        <td><span class="small text-muted bg-light px-2 py-1 rounded border">{{ $usr->created_at->format('d M Y') }}</span></td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <form action="/dashboard/user/{{ $usr->id }}/role" method="POST" class="m-0">
                                                    @csrf
                                                    <select name="role" class="form-select form-select-sm shadow-sm" onchange="this.form.submit()" style="min-width: 100px; border-radius: 8px;">
                                                        <option value="admin" {{ $usr->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="manager" {{ $usr->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                                        <option value="user" {{ $usr->role == 'user' ? 'selected' : '' }}>User</option>
                                                    </select>
                                                </form>
                                                @if($usr->id != Auth::id())
                                                    <a href="/dashboard/user/delete/{{ $usr->id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pengguna ini secara permanen?')"><i class="fa-solid fa-trash"></i></a>
                                                @else
                                                    <button class="btn btn-sm btn-outline-secondary" disabled><i class="fa-solid fa-ban"></i></button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB VOUCHERS (ADMIN ONLY) -->
                @if(Auth::user()->role == 'admin')
                <div class="tab-pane fade" id="tab-vouchers">
                    <div class="card-custom">
                        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded"><i class="fa-solid fa-ticket"></i></div>
                                Daftar Voucher Diskon
                            </h6>
                            <button class="btn btn-primary fw-semibold d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
                                <i class="fa-solid fa-plus"></i> Tambah Voucher
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead><tr><th class="ps-4">Kode Voucher</th><th>Tipe & Nilai</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($vouchers as $v)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark fs-5">{{ $v->code }}</td>
                                        <td>
                                            @if($v->type == 'percent')
                                                <span class="fw-semibold text-primary">{{ rtrim(rtrim($v->value, '0'), '.') }}%</span>
                                            @else
                                                <span class="fw-semibold text-primary">Rp {{ number_format($v->value, 0, ',', '.') }}</span>
                                            @endif
                                            <div class="small text-muted text-uppercase">{{ $v->type }}</div>
                                        </td>
                                        <td>
                                            @if($v->is_active)
                                                <span class="badge badge-soft bg-success bg-opacity-10 text-success border border-success border-opacity-25">Aktif</span>
                                            @else
                                                <span class="badge badge-soft bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editVoucher{{ $v->id }}"><i class="fa-solid fa-pen"></i></button>
                                                <a href="/dashboard/voucher/delete/{{ $v->id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus voucher ini?')"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

            </div> <!-- End Tab Content -->
        </div> <!-- End Content Area -->
    </div> <!-- End Main Wrapper -->

    <!-- ============================================== -->
    <!-- MODALS GENERATED OUTSIDE TABLE TO FIX DOM BUGS -->

    @if(Auth::user()->role == 'admin')
    <!-- Modal Tambah Hotel -->
    <div class="modal fade" id="addHotelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/hotel" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fa-solid fa-building text-primary me-2"></i>Tambah Cabang Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nama Cabang / Entitas</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Ex: Hotelku Bali"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Location Key Mapping</label><input type="text" name="location_key" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Ex: Bali (harus unik dan sama dengan entri kamar)"></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Manager / Pengelola</label>
                        <select name="owner_id" class="form-select bg-light rounded-3 border-0 py-2">
                            <option value="">-- Belum ada Manager --</option>
                            @foreach($users->where('role', 'manager') as $o)
                                <option value="{{ $o->id }}">{{ $o->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm w-100">Simpan Cabang Baru</button>
                </div>
            </form>
        </div>
    </div>

    @foreach($hotelsData ?? [] as $htl)
    <div class="modal fade" id="editHotel{{ $htl->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/hotel/update/{{ $htl->id }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fa-solid fa-pen text-primary me-2"></i>Ubah Cabang Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nama Cabang</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" value="{{ $htl->name }}"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Location Key</label><input type="text" name="location_key" class="form-control bg-light rounded-3 border-0 py-2" value="{{ $htl->location_key }}"></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Pemilik / Pengelola</label>
                        <select name="owner_id" class="form-select bg-light rounded-3 border-0 py-2">
                            <option value="">-- Kosongkan --</option>
                            @foreach($users->where('role', 'manager') as $o)
                                <option value="{{ $o->id }}" {{ $htl->owner_id == $o->id ? 'selected' : '' }}>{{ $o->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm w-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Modal Tambah Voucher -->
    <div class="modal fade" id="addVoucherModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/voucher" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fa-solid fa-ticket text-primary me-2"></i>Tambah Voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Kode Voucher (Unik)</label><input type="text" name="code" class="form-control bg-light rounded-3 border-0 py-2 text-uppercase" required placeholder="Ex: DISKON10"></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Tipe Potongan</label>
                        <select name="type" class="form-select bg-light rounded-3 border-0 py-2" required>
                            <option value="fixed">Nominal Tetap (Rp)</option>
                            <option value="percent">Persentase (%)</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nilai Diskon (Angka Saja)</label><input type="number" name="value" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Ex: 50000 atau 10"></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Status</label>
                        <select name="is_active" class="form-select bg-light rounded-3 border-0 py-2" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm w-100">Simpan Voucher</button>
                </div>
            </form>
        </div>
    </div>

    @foreach($vouchers ?? [] as $v)
    <div class="modal fade" id="editVoucher{{ $v->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/voucher/update/{{ $v->id }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fa-solid fa-pen text-primary me-2"></i>Ubah Voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Kode Voucher</label><input type="text" name="code" class="form-control bg-light rounded-3 border-0 py-2 text-uppercase" value="{{ $v->code }}" required></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Tipe Potongan</label>
                        <select name="type" class="form-select bg-light rounded-3 border-0 py-2" required>
                            <option value="fixed" {{ $v->type == 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                            <option value="percent" {{ $v->type == 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nilai Diskon</label><input type="number" name="value" class="form-control bg-light rounded-3 border-0 py-2" value="{{ rtrim(rtrim($v->value, '0'), '.') }}" required></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Status</label>
                        <select name="is_active" class="form-select bg-light rounded-3 border-0 py-2" required>
                            <option value="1" {{ $v->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$v->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm w-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
    @endif

    <!-- Modal Tambah Kamar -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/kamar" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold">Tambah Tipe Kamar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nama Kategori</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Ex: Deluxe Room"></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Pilih Cabang Hotel (Lokasi)</label>
                        <select name="location" class="form-select bg-light rounded-3 border-0 py-2">
                            @if(Auth::user()->role == 'manager')
                                @foreach($hotelsData->where('owner_id', Auth::id()) as $htl)
                                    <option value="{{ $htl->location_key }}" selected>{{ $htl->name }} ({{ $htl->location_key }})</option>
                                @endforeach
                            @else
                                <option value="">Pusat / Umum (Tanpa Cabang)</option>
                                @foreach($hotelsData as $htl)
                                    <option value="{{ $htl->location_key }}">{{ $htl->name }} ({{ $htl->location_key }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Harga per Malam</label><input type="number" name="price" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="500000"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Fasilitas / Deskripsi</label><textarea name="description" class="form-control bg-light rounded-3 border-0 py-2" rows="3" placeholder="Fasilitas kamar..."></textarea></div>
                    <div class="mb-2"><label class="small fw-semibold text-muted">Foto Kamar</label><input type="file" name="foto" class="form-control rounded-3" required></div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Menu -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/menu" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold">Tambah Menu Restoran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nama Menu</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Nasi Goreng"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Harga</label><input type="number" name="price" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="25000"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Deskripsi</label><textarea name="description" class="form-control bg-light rounded-3 border-0 py-2" rows="3" placeholder="Detail menu..."></textarea></div>
                    <div class="mb-2"><label class="small fw-semibold text-muted">Foto Menu</label><input type="file" name="foto" class="form-control rounded-3" required></div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success rounded-3 px-4 fw-bold shadow-sm">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Reservasi Manual -->
    <div class="modal fade" id="addManualBookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form action="/dashboard/booking/manual-store" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fa-solid fa-user-plus text-primary me-2"></i>Tambah Reservasi Manual (Walk-in)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-semibold text-muted">Nama Tamu</label>
                            <input type="text" name="guest_name" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Nama lengkap tamu">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-semibold text-muted">Email Tamu</label>
                            <input type="email" name="guest_email" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="email@contoh.com">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-semibold text-muted">Nomor HP / WA</label>
                            <input type="text" name="guest_phone" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-semibold text-muted">Tipe Kamar</label>
                            <select name="room_type_id" class="form-select bg-light rounded-3 border-0 py-2" required>
                                <option value="">-- Pilih Tipe Kamar --</option>
                                @foreach($rooms as $rt)
                                    <option value="{{ $rt->id }}">{{ $rt->name }} - Rp {{ number_format($rt->price, 0, ',', '.') }} ({{ $rt->location ?? 'Pusat' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="small fw-semibold text-muted">Tanggal Check-In</label>
                            <input type="date" name="check_in" class="form-control bg-light rounded-3 border-0 py-2" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small fw-semibold text-muted">Tanggal Check-Out</label>
                            <input type="date" name="check_out" class="form-control bg-light rounded-3 border-0 py-2" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small fw-semibold text-muted">Jumlah Kamar</label>
                            <input type="number" name="room_qty" class="form-control bg-light rounded-3 border-0 py-2" required min="1" max="5" value="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Status Pembayaran</label>
                        <select name="payment_status" class="form-select bg-light rounded-3 border-0 py-2" required>
                            <option value="paid">Lunas (Cash / Transfer Manual)</option>
                            <option value="pending">Belum Lunas (Bayar Nanti)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm w-100 ms-2">Buat Reservasi</button>
                </div>
            </form>
        </div>
    </div>
    <!-- ============================================== -->

    <!-- Modals for Rooms -->
    @foreach($rooms as $room)
    <div class="modal fade" id="editRoom{{ $room->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/kamar/update/{{ $room->id }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold">Ubah Tipe Kamar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nama Kategori</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" value="{{ $room->name }}"></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Pilih Cabang Hotel (Lokasi)</label>
                        <select name="location" class="form-select bg-light rounded-3 border-0 py-2">
                            @if(Auth::user()->role == 'manager')
                                @foreach($hotelsData->where('owner_id', Auth::id()) as $htl)
                                    <option value="{{ $htl->location_key }}" selected>{{ $htl->name }} ({{ $htl->location_key }})</option>
                                @endforeach
                            @else
                                <option value="" {{ empty($room->location) ? 'selected' : '' }}>Pusat / Umum (Tanpa Cabang)</option>
                                @foreach($hotelsData as $htl)
                                    <option value="{{ $htl->location_key }}" {{ $room->location == $htl->location_key ? 'selected' : '' }}>{{ $htl->name }} ({{ $htl->location_key }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Harga per Malam</label><input type="number" name="price" class="form-control bg-light rounded-3 border-0 py-2" value="{{ $room->price }}"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Fasilitas / Deskripsi</label><textarea name="description" class="form-control bg-light rounded-3 border-0 py-2" rows="3">{{ $room->description }}</textarea></div>
                    <div class="mb-2"><label class="small fw-semibold text-muted">Ganti Foto Baru</label><input type="file" name="foto" class="form-control rounded-3"><small class="text-muted" style="font-size: 0.7rem;">Kosongkan jika tidak ingin ganti</small></div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Modals for Menus -->
    @foreach($menus as $menu)
    <div class="modal fade" id="editMenu{{ $menu->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/dashboard/menu/update/{{ $menu->id }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold">Ubah Menu Restoran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nama Menu</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" value="{{ $menu->name }}"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Harga</label><input type="number" name="price" class="form-control bg-light rounded-3 border-0 py-2" value="{{ $menu->price }}"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Deskripsi</label><textarea name="description" class="form-control bg-light rounded-3 border-0 py-2" rows="3">{{ $menu->description }}</textarea></div>
                    <div class="mb-2"><label class="small fw-semibold text-muted">Ganti Foto Baru</label><input type="file" name="foto" class="form-control rounded-3"><small class="text-muted" style="font-size: 0.7rem;">Kosongkan jika tidak ingin ganti</small></div>
                </div>
                <div class="modal-header border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success rounded-3 px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

@else
    <!-- TAMPILAN USER (GUEST) -->
    <div class="d-flex flex-column min-vh-100 bg-light">
        <nav class="navbar navbar-expand-lg client-navbar sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary d-flex align-items-center gap-2" href="/">
                    <span class="fs-4 fw-bolder">Hotel<span class="text-primary">ku</span></span>
                </a>
                <div class="d-flex align-items-center gap-3">
                    @if(Auth::user()->foto_profil)
                        <img src="{{ Storage::url(Auth::user()->foto_profil) }}" width="32" height="32" class="rounded-circle shadow-sm" style="object-fit:cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3264ff&color=fff" width="32" height="32" class="rounded-circle shadow-sm">
                    @endif
                    <span class="fw-semibold text-dark d-none d-md-block">{{ Auth::user()->name }}</span>
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#profileModal"><i class="fa-solid fa-user-edit me-1"></i> Profil</button>
                    <a href="/logout" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm"><i class="fa-solid fa-sign-out-alt me-1"></i> Logout</a>
                </div>
            </div>
        </nav>

        <div class="container mt-5 flex-grow-1 mb-5">
            <h3 class="fw-bold mb-4 text-dark">Informasi Akun & Pesanan Anda</h3>
            
            <div class="card-custom mb-5 shadow">
                <div class="px-4 py-4 border-bottom bg-primary text-white" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-bed fs-4"></i>
                        <h5 class="fw-bold mb-0">Riwayat Pemesanan Kamar</h5>
                    </div>
                </div>
                <div class="p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead><tr><th class="ps-4">Tipe Kamar</th><th>Check-In / Out</th><th>Subtotal Biaya</th><th>Status Bayar</th><th class="text-center">Status Kamar</th></tr></thead>
                            <tbody>
                                @forelse($myBookings as $b)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $b->rooms->first()->roomType->name ?? '-' }}</div>
                                        <span class="badge bg-light border text-muted">Cabang {{ $b->rooms->first()->roomType->location ?? 'Pusat' }} | No Kamar: {{ $b->rooms->pluck('room_number')->implode(', ') ?: 'Belum ditentukan' }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($b->check_in)->format('d M Y') }}</div>
                                        <div class="small text-muted">s/d {{ \Carbon\Carbon::parse($b->check_out)->format('d M Y') }}</div>
                                    </td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($b->payments->where('payment_status', 'paid')->count() > 0)
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-soft bg-success text-white"><i class="fa-solid fa-check me-1"></i>Lunas</span>
                                                <a href="{{ route('booking.invoice', $b->id) }}" target="_blank" class="btn btn-sm btn-outline-success py-0 px-2 rounded-2" title="Unduh Invoice"><i class="fa-solid fa-file-pdf"></i></a>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-soft bg-danger text-white">Belum Lunas</span>
                                                <a href="/payment?type=booking&id={{ $b->id }}" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-2">Bayar</a>
                                                <form action="/dashboard/booking/{{ $b->id }}/status" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="action" value="cancel">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-2" onclick="return confirm('Anda yakin ingin membatalkan pesanan ini?')" title="Batalkan Pesanan"><i class="fa-solid fa-times"></i></button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary text-uppercase py-1 px-2 rounded-pill">{{ str_replace('_', ' ', $b->status) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted py-5"><i class="fa-solid fa-inbox fs-2 text-light mb-2 block"></i><br>Anda belum pernah melakukan pemesanan kamar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-custom shadow">
                <div class="px-4 py-4 border-bottom bg-success text-white" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-utensils fs-4"></i>
                        <h5 class="fw-bold mb-0">Riwayat Pesanan Restoran</h5>
                    </div>
                </div>
                <div class="p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead><tr><th class="ps-4">Tgl Pemesanan</th><th>Jumlah Item</th><th>Total Tagihan</th><th>Status Bayar</th></tr></thead>
                            <tbody>
                                @forelse($myOrders as $o)
                                <tr>
                                    <td class="ps-4 fw-medium text-dark">{{ $o->created_at->format('d M Y H:i') }}</td>
                                    <td><span class="badge px-3 py-2 bg-light text-dark border">{{ $o->details->sum('quantity') }} Porsi</span></td>
                                    <td class="fw-bold text-success">Rp {{ number_format($o->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($o->payments->where('payment_status', 'paid')->count() > 0)
                                            <span class="badge badge-soft bg-success text-white"><i class="fa-solid fa-check me-1"></i>Lunas</span>
                                        @else
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-soft bg-danger text-white">Belum Lunas</span>
                                                <a href="/payment?type=restaurant&id={{ $o->id }}" class="btn btn-sm btn-outline-success py-0 px-2 rounded-2">Bayar</a>
                                                <form action="/dashboard/restaurant-order/{{ $o->id }}/status" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="action" value="cancel">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-2" onclick="return confirm('Anda yakin ingin membatalkan pesanan ini?')" title="Batalkan Pesanan"><i class="fa-solid fa-times"></i></button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-5"><i class="fa-solid fa-utensils fs-2 text-light mb-2 block"></i><br>Anda belum memiliki pesanan makanan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5 mb-3">
                <a href="/" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm"><i class="fa-solid fa-plus me-2"></i>Buat Pesanan Baru</a>
            </div>

        </div>
    </div>
@endif

<!-- Modal Profil (Shared: Admin/Manager/Guest) -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="fw-bold"><i class="fa-solid fa-user-circle text-primary me-2"></i>Ubah Profil & Data Diri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <div class="mb-3 text-center">
                    @if(Auth::user()->foto_profil)
                        <img src="{{ Storage::url(Auth::user()->foto_profil) }}" width="80" height="80" class="rounded-circle shadow-sm mb-2" style="object-fit:cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3264ff&color=fff" width="80" height="80" class="rounded-circle shadow-sm mb-2">
                    @endif
                </div>
                <div class="mb-3"><label class="small fw-semibold text-muted">Nama Lengkap</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" value="{{ Auth::user()->name }}" required></div>
                <div class="mb-3"><label class="small fw-semibold text-muted">Email</label><input type="email" name="email" class="form-control bg-light rounded-3 border-0 py-2" value="{{ Auth::user()->email }}" required></div>
                <div class="mb-3"><label class="small fw-semibold text-muted">Unggah Foto Profil Baru</label><input type="file" name="foto" class="form-control rounded-3" accept="image/*"></div>
                <div class="mb-3"><label class="small fw-semibold text-muted">Password Baru (Biarkan kosong jika tidak diganti)</label><input type="password" name="password" class="form-control bg-light rounded-3 border-0 py-2" minlength="6" placeholder="******"></div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm w-100 py-2">Simpan Profil Saya</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabBtns = document.querySelectorAll('button[data-bs-toggle="pill"]');
        
        // Save the active tab to localStorage when a tab is shown
        tabBtns.forEach(btn => {
            btn.addEventListener('shown.bs.tab', function (e) {
                localStorage.setItem('activeDashboardTab', e.target.getAttribute('data-bs-target'));
            });
        });

        // Restore the active tab from localStorage if it exists
        const activeTab = localStorage.getItem('activeDashboardTab');
        if (activeTab) {
            const tabToActivate = document.querySelector(`button[data-bs-target="${activeTab}"]`);
            if (tabToActivate) {
                // Initialize bootstrap tab and show it
                const tab = new bootstrap.Tab(tabToActivate);
                tab.show();
            }
        }
        
        @if((Auth::user()->role == 'admin' || Auth::user()->role == 'manager') && isset($chartLabels) && isset($chartData))
        // Render Chart
        const ctx = document.getElementById('revenueChart');
        if(ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Total Pendapatan (Rp)',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#4a7cff',
                        backgroundColor: 'rgba(74, 124, 255, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4a7cff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw;
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if(value >= 1000000) return 'Rp ' + (value/1000000) + 'M';
                                    if(value >= 1000) return 'Rp ' + (value/1000) + 'K';
                                    return 'Rp ' + value;
                                }
                            }
                        }
                    }
                }
            });
        }
        @endif
        // Sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                if (sidebarOverlay) sidebarOverlay.classList.toggle('active');
            });
        }
        if (sidebarOverlay && sidebar) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Close sidebar when a nav tab is clicked (mobile)
        document.querySelectorAll('.nav-item-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (window.innerWidth < 992 && sidebar) {
                    sidebar.classList.remove('show');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('active');
                }
            });
        });
    });
</script>
</body>
</html>