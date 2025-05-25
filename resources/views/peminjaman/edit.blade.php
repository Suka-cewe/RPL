@extends('layouts.app')

@section('title', 'Pengembalian Buku')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengembalian Buku</h1>
    <a href="{{ route('peminjaman.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pengembalian Buku</h6>
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

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Detail Peminjaman</div>
                        <table class="table table-borderless mt-3">
                            <tr>
                                <th>Judul Buku</th>
                                <td>: {{ $buku->judul_buku }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <td>: {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Batas Pengembalian</th>
                                <td>: {{ $peminjaman->tanggal_wajib_kembali->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: <span class="badge badge-primary">{{ $peminjaman->status_peminjaman }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Perhatian</div>
                        <ul class="mt-3">
                            <li>Keterlambatan pengembalian akan dikenakan denda Rp 1.000/hari.</li>
                            <li>Pastikan buku dalam kondisi baik saat dikembalikan.</li>
                            <li>Tanggal pengembalian adalah tanggal saat buku benar-benar dikembalikan ke perpustakaan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_pengembalian">Tanggal Pengembalian <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', date('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="konfirmasi" required>
                            <label class="custom-control-label" for="konfirmasi">Saya mengkonfirmasi bahwa buku telah dikembalikan dalam kondisi baik</label>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Kembalikan Buku</button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
                <div class="col-md-6">
                    @php
                        $today = \Carbon\Carbon::today();
                        $deadlineDate = \Carbon\Carbon::parse($peminjaman->tanggal_wajib_kembali);
                        $isLate = $today->gt($deadlineDate);
                        $daysLate = $isLate ? $today->diffInDays($deadlineDate) : 0;
                        $estimatedFine = $daysLate * 1000;
                    @endphp
                    
                    @if($isLate)
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Keterlambatan Terdeteksi!</h5>
                        <p>Buku ini terlambat dikembalikan selama {{ $daysLate }} hari.</p>
                        <p class="mb-0">Estimasi denda: <strong>Rp {{ number_format($estimatedFine, 0, ',', '.') }}</strong></p>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Set minimum date for tanggal_pengembalian to be the loan date
    document.getElementById('tanggal_pengembalian').min = "{{ $peminjaman->tanggal_pinjam->format('Y-m-d') }}";
</script>
@endsection 