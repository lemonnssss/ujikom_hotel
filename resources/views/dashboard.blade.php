<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard - Hotelku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; width: 250px; background-color: #0f294d; }
        .sidebar .nav-link { color: #a1b0cb; border-radius: 8px; margin-bottom: 5px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #3264ff; color: white; }
        .main-content { flex-grow: 1; background-color: #f5f7fa; min-height: 100vh; }
    </style>
</head>
<body class="d-flex">

    @if(Auth::user()->role == 'admin')
    <div class="sidebar p-3 d-flex flex-column shadow">
        <a href="/" class="text-white text-decoration-none mb-4 d-flex align-items-center justify-content-center mt-3">
            <i class="fa-solid fa-hotel fa-2x me-2 text-primary"></i>
            <span class="fs-4 fw-bold">Hotelku</span>
        </a>
        
        <hr class="text-secondary mb-4">

        <ul class="nav nav-pills flex-column mb-auto" id="dashboard-tabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active w-100 text-start px-3 py-2" data-bs-toggle="pill" data-bs-target="#tab-hotel">
                    <i class="fa-solid fa-bed me-2 w-20px"></i> Kamar & Lokasi
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link w-100 text-start px-3 py-2 mt-2" data-bs-toggle="pill" data-bs-target="#tab-resto">
                    <i class="fa-solid fa-utensils me-2 w-20px"></i> Restoran
                </button>
            </li>
        </ul>

        <hr class="text-secondary">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=3264ff&color=fff" width="32" height="32" class="rounded-circle me-2">
                <strong>{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item text-danger" href="/logout"><i class="fa-solid fa-sign-out-alt me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content p-4">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="tab-hotel">
                <h3 class="fw-bold mb-4">Manajemen Kamar & Lokasi</h3>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white pt-3 pb-2 border-0"><h6 class="fw-bold text-primary mb-0"><i class="fa-solid fa-plus me-2"></i>Tambah Kategori</h6></div>
                            <div class="card-body">
                                <form action="/dashboard/kamar" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3"><label class="form-label small fw-bold">Nama Kategori</label><input type="text" name="name" class="form-control" required placeholder="Ex: Deluxe Room"></div>
                                    <div class="mb-3"><label class="form-label small fw-bold">Lokasi / Cabang</label><input type="text" name="location" class="form-control" placeholder="Ex: Lantai 2 / Bandung"></div>
                                    <div class="mb-3"><label class="form-label small fw-bold">Harga per Malam</label><input type="number" name="price" class="form-control" required></div>
                                    <div class="mb-3"><label class="form-label small fw-bold">Fasilitas / Deskripsi</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                                    <div class="mb-4"><label class="form-label small fw-bold">Upload Foto</label><input type="file" name="foto" class="form-control form-control-sm"></div>
                                    <button class="btn btn-primary w-100 fw-bold">Simpan Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white pt-3 pb-0 border-0 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0">Daftar Kamar</h6>
                                <form action="" method="GET" class="d-flex">
                                    <input type="text" name="search_room" class="form-control form-control-sm me-2 bg-light border-0" placeholder="Cari nama kamar...">
                                    <button class="btn btn-sm btn-dark px-3"><i class="fa-solid fa-search"></i></button>
                                </form>
                            </div>
                            <div class="card-body p-0 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light text-muted small">
                                            <tr><th class="ps-4">Info Kamar</th><th>Lokasi</th><th>Harga</th><th class="text-end pe-4">Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rooms as $room)
                                            <tr>
                                                <td class="ps-4 d-flex align-items-center mt-2">
                                                    <img src="{{ Str::startsWith($room->foto_url, 'http') ? $room->foto_url : asset('storage/' . $room->foto_url) }}" width="50" height="50" class="rounded object-fit-cover me-3 shadow-sm">
                                                    <div><h6 class="mb-0 fw-bold">{{ $room->name }}</h6><span class="text-muted small text-truncate d-inline-block" style="max-width: 150px;">{{ $room->description }}</span></div>
                                                </td>
                                                <td><span class="badge bg-info text-dark"><i class="fa-solid fa-map-pin me-1"></i>{{ $room->location ?? 'Umum' }}</span></td>
                                                <td class="fw-bold text-success">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                                                <td class="text-end pe-4">
                                                    <button class="btn btn-sm btn-light border text-primary" data-bs-toggle="modal" data-bs-target="#editRoom{{ $room->id }}"><i class="fa-solid fa-edit"></i></button>
                                                    <a href="/dashboard/kamar/delete/{{ $room->id }}" class="btn btn-sm btn-light border text-danger" onclick="return confirm('Hapus kamar ini?')"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editRoom{{ $room->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form action="/dashboard/kamar/update/{{ $room->id }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
                                                        @csrf
                                                        <div class="modal-header border-0 pb-0">
                                                            <h5 class="fw-bold">Edit Data Kamar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3"><label class="small fw-bold">Nama Kategori</label><input type="text" name="name" class="form-control bg-light border-0" value="{{ $room->name }}"></div>
                                                            <div class="mb-3"><label class="small fw-bold">Lokasi / Cabang</label><input type="text" name="location" class="form-control bg-light border-0" value="{{ $room->location }}"></div>
                                                            <div class="mb-3"><label class="small fw-bold">Harga</label><input type="number" name="price" class="form-control bg-light border-0" value="{{ $room->price }}"></div>
                                                            <div class="mb-3"><label class="small fw-bold">Deskripsi</label><textarea name="description" class="form-control bg-light border-0">{{ $room->description }}</textarea></div>
                                                            <div class="mb-3"><label class="small fw-bold">Ganti Foto <span class="text-muted fw-normal">(Abaikan jika tidak ingin ganti)</span></label><input type="file" name="foto" class="form-control"></div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button class="btn btn-primary px-4">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-resto">
                <h3 class="fw-bold mb-4">Manajemen Restoran</h3>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white pt-3 pb-2 border-0"><h6 class="fw-bold text-success mb-0"><i class="fa-solid fa-plus me-2"></i>Tambah Menu</h6></div>
                            <div class="card-body">
                                <form action="/dashboard/menu" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3"><label class="form-label small fw-bold">Nama Menu</label><input type="text" name="name" class="form-control" required></div>
                                    <div class="mb-3"><label class="form-label small fw-bold">Harga</label><input type="number" name="price" class="form-control" required></div>
                                    <div class="mb-3"><label class="form-label small fw-bold">Deskripsi</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                                    <div class="mb-4"><label class="form-label small fw-bold">Upload Foto</label><input type="file" name="foto" class="form-control form-control-sm"></div>
                                    <button class="btn btn-success w-100 fw-bold">Simpan Menu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white pt-3 pb-0 border-0 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0">Daftar Menu</h6>
                                <form action="" method="GET" class="d-flex">
                                    <input type="text" name="search_menu" class="form-control form-control-sm me-2 bg-light border-0" placeholder="Cari makanan...">
                                    <button class="btn btn-sm btn-dark px-3"><i class="fa-solid fa-search"></i></button>
                                </form>
                            </div>
                            <div class="card-body p-0 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light text-muted small">
                                            <tr><th class="ps-4">Menu</th><th>Harga</th><th class="text-end pe-4">Aksi</th></tr>
                                        </thead>
                                        <tbody>
                                            @foreach($menus as $menu)
                                            <tr>
                                                <td class="ps-4 d-flex align-items-center mt-2">
                                                    <img src="{{ Str::startsWith($menu->foto_url, 'http') ? $menu->foto_url : asset('storage/' . $menu->foto_url) }}" width="50" height="50" class="rounded object-fit-cover me-3 shadow-sm">
                                                    <div><h6 class="mb-0 fw-bold">{{ $menu->name }}</h6><span class="text-muted small text-truncate d-inline-block" style="max-width: 200px;">{{ $menu->description }}</span></div>
                                                </td>
                                                <td class="fw-bold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                                <td class="text-end pe-4">
                                                    <button class="btn btn-sm btn-light border text-primary" data-bs-toggle="modal" data-bs-target="#editMenu{{ $menu->id }}"><i class="fa-solid fa-edit"></i></button>
                                                    <a href="/dashboard/menu/delete/{{ $menu->id }}" class="btn btn-sm btn-light border text-danger" onclick="return confirm('Hapus menu ini?')"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editMenu{{ $menu->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form action="/dashboard/menu/update/{{ $menu->id }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
                                                        @csrf
                                                        <div class="modal-header border-0 pb-0">
                                                            <h5 class="fw-bold">Edit Menu</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3"><label class="small fw-bold">Nama Menu</label><input type="text" name="name" class="form-control bg-light border-0" value="{{ $menu->name }}"></div>
                                                            <div class="mb-3"><label class="small fw-bold">Harga</label><input type="number" name="price" class="form-control bg-light border-0" value="{{ $menu->price }}"></div>
                                                            <div class="mb-3"><label class="small fw-bold">Deskripsi</label><textarea name="description" class="form-control bg-light border-0">{{ $menu->description }}</textarea></div>
                                                            <div class="mb-3"><label class="small fw-bold">Ganti Foto <span class="text-muted fw-normal">(Abaikan jika tidak ingin ganti)</span></label><input type="file" name="foto" class="form-control"></div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button class="btn btn-success px-4">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @else
    <div class="main-content w-100 d-flex flex-column">
        <nav class="navbar navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand fw-bold" href="/">Hotelku</a>
                <a href="/logout" class="btn btn-sm btn-outline-danger">Logout</a>
            </div>
        </nav>
        <div class="container mt-5 flex-grow-1">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center py-5">
                    <h3 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}</h3>
                    <p class="text-muted">Riwayat pemesanan kamar dan restoran Anda akan muncul di sini.</p>
                    <a href="/" class="btn btn-primary mt-3 px-4 rounded-pill">Pesan Kamar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    @endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>