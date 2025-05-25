@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Buku</h1>
    <a href="{{ route('buku.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Buku</h6>
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

        <form action="{{ route('buku.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="judul_buku">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}">
                    </div>
                    <div class="form-group">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}">
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" min="1900" max="{{ date('Y') }}" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}">
                        <small class="form-text text-muted">Format: 978-XXXX-XXXX-X (Opsional)</small>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Fiksi" {{ old('kategori', $buku->kategori) == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                            <option value="Non-Fiksi" {{ old('kategori', $buku->kategori) == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                            <option value="Pelajaran" {{ old('kategori', $buku->kategori) == 'Pelajaran' ? 'selected' : '' }}>Pelajaran</option>
                            <option value="Referensi" {{ old('kategori', $buku->kategori) == 'Referensi' ? 'selected' : '' }}>Referensi</option>
                            <option value="Cerita Anak" {{ old('kategori', $buku->kategori) == 'Cerita Anak' ? 'selected' : '' }}>Cerita Anak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_stok">Jumlah Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jumlah_stok" name="jumlah_stok" min="0" value="{{ old('jumlah_stok', $buku->jumlah_stok) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_rak">Lokasi Rak</label>
                        <input type="text" class="form-control" id="lokasi_rak" name="lokasi_rak" value="{{ old('lokasi_rak', $buku->lokasi_rak) }}">
                        <small class="form-text text-muted">Contoh: A1-01 (Opsional)</small>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Perbarui Buku</button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection 