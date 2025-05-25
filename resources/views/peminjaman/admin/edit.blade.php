@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Peminjaman</h1>
    <a href="{{ route('peminjaman.admin.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Peminjaman</h6>
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
                                <th>Peminjam</th>
                                <td>: {{ $peminjaman->siswa->name }}</td>
                            </tr>
                            <tr>
                                <th>Buku</th>
                                <td>: {{ $peminjaman->buku->judul_buku }}</td>
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
                            <li>Perubahan tanggal pinjam akan mempengaruhi perhitungan denda.</li>
                            <li>Pastikan perubahan data sesuai dengan kondisi sebenarnya.</li>
                            <li>Perubahan status peminjaman akan mempengaruhi stok buku.</li>
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
                        <label for="tanggal_pinjam">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_wajib_kembali">Tanggal Wajib Kembali <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_wajib_kembali" name="tanggal_wajib_kembali" value="{{ old('tanggal_wajib_kembali', $peminjaman->tanggal_wajib_kembali->format('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                        <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', $peminjaman->tanggal_pengembalian ? $peminjaman->tanggal_pengembalian->format('Y-m-d') : '') }}">
                        <small class="form-text text-muted">Kosongkan jika buku belum dikembalikan</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_peminjaman">Status Peminjaman <span class="text-danger">*</span></label>
                        <select class="form-control" id="status_peminjaman" name="status_peminjaman" required>
                            <option value="Dipinjam" {{ old('status_peminjaman', $peminjaman->status_peminjaman) == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Dikembalikan" {{ old('status_peminjaman', $peminjaman->status_peminjaman) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="Terlambat" {{ old('status_peminjaman', $peminjaman->status_peminjaman) == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="denda">Denda (Rp)</label>
                        <input type="number" class="form-control" id="denda" name="denda" value="{{ old('denda', $peminjaman->denda) }}" min="0">
                        <small class="form-text text-muted">Kosongkan jika tidak ada denda</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="konfirmasi" required>
                            <label class="custom-control-label" for="konfirmasi">Saya mengkonfirmasi bahwa perubahan data ini sesuai dengan kondisi sebenarnya</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('peminjaman.admin.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Set minimum date for tanggal_pinjam
        document.getElementById('tanggal_pinjam').min = "{{ $peminjaman->tanggal_pinjam->format('Y-m-d') }}";
        
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

        // Show/hide tanggal_pengembalian based on status
        $('#status_peminjaman').change(function() {
            if ($(this).val() === 'Dipinjam') {
                $('#tanggal_pengembalian').val('');
                $('#tanggal_pengembalian').prop('disabled', true);
            } else {
                $('#tanggal_pengembalian').prop('disabled', false);
            }
        }).trigger('change');
    });
</script>
@endsection 