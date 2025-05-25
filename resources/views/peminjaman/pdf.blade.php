<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 10px;
        }
        h1 {
            font-size: 22px;
            margin: 0;
            padding: 0;
        }
        h2 {
            font-size: 16px;
            margin: 5px 0;
            font-weight: normal;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: right;
            margin-top: 30px;
            font-size: 12px;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
            display: inline-block;
        }
        .badge-primary {
            background-color: #4e73df;
        }
        .badge-success {
            background-color: #1cc88a;
        }
        .badge-danger {
            background-color: #e74a3b;
        }
        .summary {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .summary-table {
            width: 50%;
            margin-bottom: 20px;
            border: none;
        }
        .summary-table th, .summary-table td {
            border: none;
            padding: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERPUSTAKAAN SDN 019 PENAJAM</h1>
        <h2>Laporan Peminjaman Buku</h2>
        <p>Tanggal Cetak: {{ date('d/m/Y') }}</p>
    </div>
    
    <div class="info">
        <p>Berikut adalah data peminjaman buku perpustakaan SDN 019 Penajam.</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($peminjamans as $peminjaman)
            <tr>
                <td>{{ $no++ }}</td>
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
                        Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="summary">
        <h3>Ringkasan</h3>
        <table class="summary-table">
            <tr>
                <th>Total Peminjaman</th>
                <td>: {{ $peminjamans->count() }}</td>
            </tr>
            <tr>
                <th>Peminjaman Aktif</th>
                <td>: {{ $peminjamans->where('status_peminjaman', 'Dipinjam')->count() }}</td>
            </tr>
            <tr>
                <th>Dikembalikan Tepat Waktu</th>
                <td>: {{ $peminjamans->where('status_peminjaman', 'Dikembalikan')->count() }}</td>
            </tr>
            <tr>
                <th>Terlambat</th>
                <td>: {{ $peminjamans->where('status_peminjaman', 'Terlambat')->count() }}</td>
            </tr>
            <tr>
                <th>Total Denda</th>
                <td>: Rp {{ number_format($peminjamans->sum('denda'), 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        <p>Dokumen ini dicetak oleh sistem LibZone - Perpustakaan SDN 019 Penajam</p>
        <p>&copy; {{ date('Y') }} LibZone</p>
    </div>
</body>
</html> 