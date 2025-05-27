@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Buku Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_buku'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Peminjaman Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Peminjaman</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_peminjaman'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Peminjaman Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_peminjaman_aktif'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Siswa Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_siswa'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->role == 'admin')
    <!-- Total Pengunjung Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Pengunjung</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_pengunjung'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Petugas Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total Petugas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_petugas'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- About Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tentang Perpustakaan SDN 019 Penajam</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8">
                <p>Perpustakaan SDN 019 Penajam merupakan pusat pengetahuan dan informasi bagi seluruh siswa dan guru. Perpustakaan ini menyediakan berbagai macam buku dari buku pelajaran, ensiklopedia, kamus, hingga buku cerita untuk membantu siswa dalam proses belajar.</p>
                <p>Perpustakaan SDN 019 Penajam memiliki tujuan sebagai berikut:</p>
                <ul>
                    <li>Membantu siswa dalam mencari informasi tambahan untuk menunjang kegiatan belajar mengajar.</li>
                    <li>Membudayakan kebiasaan membaca sejak dini.</li>
                    <li>Menyediakan sumber-sumber informasi yang beragam.</li>
                    <li>Menciptakan lingkungan belajar yang nyaman dan kondusif.</li>
                </ul>
                <p>Dengan adanya sistem LibZone, pengelolaan perpustakaan menjadi lebih efisien dan pelayanan kepada siswa menjadi lebih baik.</p>
            </div>
            <div class="col-lg-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <div class="text-white-50 small">Jam Operasional:</div>
                        <div class="mb-2">Senin - Jumat: 07.30 - 14.00 WIB</div>
                        <div class="text-white-50 small">Petugas Perpustakaan:</div>
                        <div>Ibu Siti Nurhaliza</div>
                    </div>
                </div>
                <div class="card bg-success text-white shadow mt-3">
                    <div class="card-body">
                        <div class="text-white-50 small">Alamat:</div>
                        <div>Jl. Maridan, Kec. Sepaku, Kabupaten Penajam Paser Utara, Kalimantan Timur 76146</div>
                        <div class="text-white-50 small mt-2">Kontak:</div>
                        <div>Telp: (0541) 123456</div>
                        <div>Email: perpus.sdn019@example.com</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 