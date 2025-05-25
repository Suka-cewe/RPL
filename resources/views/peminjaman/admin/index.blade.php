@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Peminjaman</h1>
    <div>
        <a href="{{ route('peminjaman.pdf') }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm mr-2">
            <i class="fas fa-file-pdf fa-sm text-white-50"></i> Generate PDF
        </a>
        <a href="{{ route('peminjaman.admin.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Peminjaman
        </a>
    </div>
</div>

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Buku</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
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

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $index => $peminjaman)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $peminjaman->siswa->name }}</td>
                        <td>{{ $peminjaman->buku->judul_buku }}</td>
                        <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $peminjaman->tanggal_wajib_kembali->format('d/m/Y') }}</td>
                        <td>{{ $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($peminjaman->status_peminjaman == 'Dipinjam')
                                <span class="badge badge-primary">{{ $peminjaman->status_peminjaman }}</span>
                            @elseif($peminjaman->status_peminjaman == 'Dikembalikan')
                                <span class="badge badge-success">{{ $peminjaman->status_peminjaman }}</span>
                            @else
                                <span class="badge badge-danger">{{ $peminjaman->status_peminjaman }}</span>
                            @endif
                        </td>
                        <td>
                            @if($peminjaman->denda > 0)
                                <span class="text-danger">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($peminjaman->status_peminjaman == 'Dipinjam')
                                    <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-sm btn-success" title="Pengembalian">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                @endif
                                <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data peminjaman ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Card untuk statistik peminjaman -->
<div class="row">
    <!-- Peminjaman Aktif -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Peminjaman Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamans->where('status_peminjaman', 'Dipinjam')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-reader fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Dikembalikan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Dikembalikan Tepat Waktu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamans->where('status_peminjaman', 'Dikembalikan')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Terlambat -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Terlambat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamans->where('status_peminjaman', 'Terlambat')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Denda -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Denda</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($peminjamans->sum('denda'), 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            order: [[3, 'desc']] // Order by tanggal pinjam (column 3) descending
        });
    });
</script>
@endsection 