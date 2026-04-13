<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Premium Hotel</title>
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
    </style>
</head>
<body>

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
    <!-- ADMIN SIDEBAR -->
    <div class="sidebar shadow-lg">
        <div class="sidebar-header">
            <a href="/" class="sidebar-brand">
                <i class="fa-solid fa-hotel text-primary"></i>
                <span>Premium Hotel</span>
            </a>
        </div>
        
        <div class="nav-menu" role="tablist">
            <p class="text-xs fw-bold text-uppercase mb-3 px-3" style="color: #64748b; letter-spacing: 1px;">Manajemen</p>
            @if(Auth::user()->role == 'admin')
            <button class="nav-item-btn active" data-bs-toggle="pill" data-bs-target="#tab-hotels-list">
                <i class="fa-solid fa-building w-20px text-center"></i> Kelola Cabang Hotel
            </button>
            @endif
            <button class="nav-item-btn {{ Auth::user()->role == 'owner' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#tab-hotel">
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
            @endif
        </div>
        
        <div class="p-4 border-top border-secondary border-opacity-10">
            <div class="d-flex align-items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=3264ff&color=fff" width="40" height="40" class="rounded-circle shadow-sm">
                <div>
                    <h6 class="mb-0 text-white fw-semibold small">{{ Auth::user()->name }}</h6>
                    <span class="text-white-50 small" style="font-size: 0.7rem;">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <h5 class="fw-bold mb-0 text-dark">Dasbor Admin</h5>
                @if(Auth::user()->role == 'admin')
                <form action="" method="GET" class="m-0">
                    <select name="hotel" onchange="this.form.submit()" class="form-select form-select-sm border-0 bg-light shadow-sm text-primary" style="min-width: 180px; font-weight: 600;">
                        <option value="">-- Semua Cabang Hotel --</option>
                        @foreach($hotelsList as $h)
                            <option value="{{ $h }}" {{ $selectedHotel == $h ? 'selected' : '' }}>Premium Hotel {{ $h }}</option>
                        @endforeach
                    </select>
                </form>
                @else
                <span class="badge bg-primary text-white px-3 py-2 shadow-sm rounded-pill"><i class="fa-solid fa-building me-1"></i> Cabang: {{ str_replace('_', ' ', $selectedHotel) }}</span>
                @endif
            </div>
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

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4 d-flex align-items-center" role="alert">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px;"><i class="fa-solid fa-check small"></i></div>
                    <span class="fw-medium">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Stats Row -->
            <div class="row g-4 mb-4 justify-content-center">
                @if(Auth::user()->role == 'admin')
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
                @endif
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

            <!-- TAB CONTENTS -->
            <div class="tab-content" id="pills-tabContent">
                
                @if(Auth::user()->role == 'admin')
                <!-- TAB HOTELS (ADMIN ONLY) -->
                <div class="tab-pane fade show active" id="tab-hotels-list">
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
                                <thead><tr><th class="ps-4">Cabang Hotel</th><th>Key Mapping</th><th>Pemilik (Owner)</th><th class="text-end">Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($hotelsData as $htl)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $htl->name }}</td>
                                        <td><span class="badge badge-soft bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $htl->location_key }}</span></td>
                                        <td>
                                            @if($htl->owner)
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-user-tie text-muted"></i> <span class="fw-medium text-dark">{{ $htl->owner->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted small"><i class="fa-solid fa-exclamation-circle text-warning me-1"></i>Belum Ada Pemilik</span>
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
                <div class="tab-pane fade {{ Auth::user()->role == 'owner' ? 'show active' : '' }}" id="tab-hotel">
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
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ Str::startsWith($room->foto_url, 'http') ? $room->foto_url : asset('storage/' . $room->foto_url) }}" class="rounded-3 shadow-sm object-fit-cover" style="width: 60px; height: 60px;">
                                                        <div>
                                                            <h6 class="mb-1 fw-bold text-dark">{{ $room->name }}</h6>
                                                            <p class="mb-0 text-muted small text-truncate" style="max-width: 180px;">{{ $room->description }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge badge-soft bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $room->location ?? 'Umum' }}</span></td>
                                                <td class="fw-bold text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                                                <td class="text-end">
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
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ Str::startsWith($menu->foto_url, 'http') ? $menu->foto_url : asset('storage/' . $menu->foto_url) }}" class="rounded-3 shadow-sm object-fit-cover" style="width: 60px; height: 60px;">
                                                        <div>
                                                            <h6 class="mb-1 fw-bold text-dark">{{ $menu->name }}</h6>
                                                            <p class="mb-0 text-muted small text-truncate" style="max-width: 250px;">{{ $menu->description }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
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
                        <div class="px-4 py-3 border-bottom">
                            <h6 class="fw-bold mb-0 text-dark">Daftar Reservasi Tamu</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom table-hover">
                                <thead><tr><th>Info Tamu</th><th>Detail Kamar / Tgl</th><th>Total Tagihan</th><th>Pembayaran</th><th class="text-end">Status & Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($allBookings as $b)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $b->guest->name ?? '-' }}</div>
                                            <div class="small text-muted">{{ $b->guest->email ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-primary">{{ $b->room->roomType->name ?? '-' }} <span class="badge bg-secondary ms-1">No. {{ $b->room->room_number ?? '-' }}</span></div>
                                            <div class="small text-muted">Cabang {{ $b->room->roomType->location ?? 'Pusat' }}</div>
                                            <div class="small text-muted mt-1"><i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($b->check_in)->format('d M') }} - {{ \Carbon\Carbon::parse($b->check_out)->format('d M') }}</div>
                                        </td>
                                        <td class="fw-bold text-dark">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @if($b->payments->where('payment_status', 'paid')->count() > 0)
                                                <span class="badge badge-soft bg-success text-white px-3"><i class="fa-solid fa-check me-1"></i>PAID</span>
                                            @else
                                                <span class="badge badge-soft bg-danger text-white px-3"><i class="fa-solid fa-clock me-1"></i>PENDING</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
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
                                                        <option value="owner" {{ $usr->role == 'owner' ? 'selected' : '' }}>Owner</option>
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
                    <div class="mb-3"><label class="small fw-semibold text-muted">Nama Cabang / Entitas</label><input type="text" name="name" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Ex: Premium Hotel Bali"></div>
                    <div class="mb-3"><label class="small fw-semibold text-muted">Location Key Mapping</label><input type="text" name="location_key" class="form-control bg-light rounded-3 border-0 py-2" required placeholder="Ex: Bali (harus unik dan sama dengan entri kamar)"></div>
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted">Pemilik / Pengelola (Owner)</label>
                        <select name="owner_id" class="form-select bg-light rounded-3 border-0 py-2">
                            <option value="">-- Belum ada / Non-Owner --</option>
                            @foreach($users->where('role', 'owner') as $o)
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
                            @foreach($users->where('role', 'owner') as $o)
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
                    <div class="mb-3"><label class="small fw-semibold text-muted">Lokasi / Lantai</label><input type="text" name="location" class="form-control bg-light rounded-3 border-0 py-2" placeholder="Ex: Lantai 2 / Mawar"></div>
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
                    <div class="mb-3"><label class="small fw-semibold text-muted">Lokasi / Lantai</label><input type="text" name="location" class="form-control bg-light rounded-3 border-0 py-2" value="{{ $room->location }}"></div>
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
                    <i class="fa-solid fa-hotel"></i> Premium Hotel
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-semibold text-dark"><i class="fa-regular fa-user-circle me-1"></i> {{ Auth::user()->name }}</span>
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
                                        <div class="fw-bold text-dark">{{ $b->room->roomType->name ?? '-' }}</div>
                                        <span class="badge bg-light border text-muted">Cabang {{ $b->room->roomType->location ?? 'Pusat' }} | No Kamar: {{ $b->room->room_number ?? 'Belum ditentukan' }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($b->check_in)->format('d M Y') }}</div>
                                        <div class="small text-muted">s/d {{ \Carbon\Carbon::parse($b->check_out)->format('d M Y') }}</div>
                                    </td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($b->payments->where('payment_status', 'paid')->count() > 0)
                                            <span class="badge badge-soft bg-success text-white"><i class="fa-solid fa-check me-1"></i>Lunas</span>
                                        @else
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-soft bg-danger text-white">Belum Lunas</span>
                                                <a href="/payment?type=booking&id={{ $b->id }}" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-2">Bayar</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>