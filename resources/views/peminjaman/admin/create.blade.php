@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Peminjaman</h1>
    <a href="{{ route('peminjaman.admin.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Peminjaman</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="siswa_user_id">Pilih Siswa <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="siswa_user_id" name="siswa_user_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('siswa_user_id') == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->name }} {{ $siswa->nomor_induk_siswa ? '('.$siswa->nomor_induk_siswa.')' : '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="buku_id">Pilih Buku <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="buku_id" name="buku_id" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                {{ $buku->judul_buku }} (Stok: {{ $buku->jumlah_stok }})
                            </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Hanya menampilkan buku yang memiliki stok tersedia.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_pinjam">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_wajib_kembali">Tanggal Wajib Kembali <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_wajib_kembali" name="tanggal_wajib_kembali" value="{{ old('tanggal_wajib_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required>
                        <small class="form-text text-muted">Maksimal peminjaman adalah 7 hari.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Informasi Peminjaman</div>
                            <ul class="mt-3">
                                <li>Peminjaman maksimal 7 hari.</li>
                                <li>Keterlambatan pengembalian akan dikenakan denda Rp 1.000/hari.</li>
                                <li>Kerusakan atau kehilangan buku akan dikenakan biaya penggantian.</li>
                                <li>Perpustakaan buka Senin-Jumat, 07.30-14.00 WIB.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card border-left-warning shadow h-100 py-2 mt-3">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Riwayat Peminjaman Siswa</div>
                            <div id="peminjaman-info" class="mt-3">
                                <p class="text-center text-muted">Pilih siswa untuk melihat riwayat peminjaman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
                <a href="{{ route('peminjaman.admin.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        
        // Set minimum date for tanggal_pinjam to today
        document.getElementById('tanggal_pinjam').min = new Date().toISOString().split("T")[0];
        
        // Update tanggal_wajib_kembali when tanggal_pinjam changes
        $('#tanggal_pinjam').change(function() {
            var pinjamDate = new Date($(this).val());
            pinjamDate.setDate(pinjamDate.getDate() + 7);
            
            var month = pinjamDate.getMonth() + 1;
            var day = pinjamDate.getDate();
            var year = pinjamDate.getFullYear();
            
            if(month < 10) month = '0' + month;
            if(day < 10) day = '0' + day;
            
            var maxDate = year + '-' + month + '-' + day;
            $('#tanggal_wajib_kembali').val(maxDate);
            document.getElementById('tanggal_wajib_kembali').min = $(this).val();
        });
        
        // Untuk implementasi yang lebih lengkap, Anda bisa menambahkan:
        // 1. Ajax untuk mendapatkan riwayat peminjaman siswa saat siswa dipilih
        // 2. Verifikasi ketersediaan buku secara real-time
    });
</script>
@endsection 