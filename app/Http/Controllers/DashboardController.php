<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengunjung;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'total_buku' => Buku::count(),
            'total_peminjaman' => Peminjaman::count(),
            'total_peminjaman_aktif' => Peminjaman::where('status_peminjaman', 'Dipinjam')->count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
        ];

        if (Auth::user() && Auth::user()->isAdmin()) {
            $stats['total_pengunjung'] = Pengunjung::count();
            $stats['total_petugas'] = Petugas::count();
        }

        return view('dashboard', compact('stats'));
    }
}
