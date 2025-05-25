@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Peminjaman Saya</h1>
    <a href="{{ route('peminjaman.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Pinjam Buku
    </a>
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
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Pengembalian</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $index => $peminjaman)
                    <tr>
                        <td>{{ $index + 1 }}</td>
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
                            @if($peminjaman->status_peminjaman == 'Dipinjam')
                                <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-undo"></i> Kembalikan
                                </a>
                            @else
                                <span class="text-muted">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
            order: [[2, 'desc']] // Order by tanggal pinjam (column 2) descending
        });
    });
</script>
@endsection 