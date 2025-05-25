@extends('layouts.app')

@section('title', 'Edit Petugas')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Petugas</h1>
    <a href="{{ route('petugas.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Petugas</h6>
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

        <form action="{{ route('petugas.update', $petuga->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_petugas">Nama Petugas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" value="{{ old('nama_petugas', $petuga->nama_petugas) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $petuga->jabatan) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kontak">Kontak</label>
                        <input type="text" class="form-control" id="kontak" name="kontak" value="{{ old('kontak', $petuga->kontak) }}">
                        <small class="form-text text-muted">Nomor telepon atau email</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="user_id">Akun Admin (Opsional)</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $petuga->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih akun admin yang akan dikaitkan dengan petugas ini</small>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('petugas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection 