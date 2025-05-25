@extends('layouts.app')

@section('title', 'Data Petugas')

@section('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Petugas</h1>
    <a href="{{ route('petugas.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Petugas
    </a>
</div>

<!-- DataTables Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Petugas Perpustakaan</h6>
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
                        <th>Nama Petugas</th>
                        <th>Jabatan</th>
                        <th>Kontak</th>
                        <th>Akun User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($petugas as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->nama_petugas }}</td>
                        <td>{{ $p->jabatan ?? '-' }}</td>
                        <td>{{ $p->kontak ?? '-' }}</td>
                        <td>
                            @if($p->user)
                                {{ $p->user->name }} ({{ $p->user->email }})
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('petugas.edit', $p->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('petugas.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data petugas ini?')">
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

<!-- Informasi Perpustakaan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Perpustakaan</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Jadwal Piket Petugas</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Senin</td>
                            <td>Ibu Siti Nurhaliza</td>
                        </tr>
                        <tr>
                            <td>Selasa</td>
                            <td>Bapak Ahmad Dhani</td>
                        </tr>
                        <tr>
                            <td>Rabu</td>
                            <td>Ibu Siti Nurhaliza</td>
                        </tr>
                        <tr>
                            <td>Kamis</td>
                            <td>Bapak Ahmad Dhani</td>
                        </tr>
                        <tr>
                            <td>Jumat</td>
                            <td>Ibu Siti Nurhaliza</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Jam Layanan Perpustakaan</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Senin - Kamis</td>
                            <td>07.30 - 14.00 WIB</td>
                        </tr>
                        <tr>
                            <td>Jumat</td>
                            <td>07.30 - 11.30 WIB</td>
                        </tr>
                        <tr>
                            <td>Sabtu - Minggu</td>
                            <td>TUTUP</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="alert alert-info mt-3">
                    <h5 class="alert-heading">Kontak Perpustakaan</h5>
                    <p>Untuk informasi lebih lanjut, silakan hubungi:</p>
                    <ul class="mb-0">
                        <li>Telp: (0541) 123456</li>
                        <li>Email: perpus.sdn019@example.com</li>
                    </ul>
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
            }
        });
    });
</script>
@endsection 