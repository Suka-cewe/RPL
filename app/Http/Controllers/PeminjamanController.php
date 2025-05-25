<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource for Siswa.
     */
    public function index()
    {
        // For siswa, only show their own peminjaman
        $peminjamans = Peminjaman::where('siswa_user_id', Auth::id())
            ->with(['buku', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * Display a listing of the resource for Admin.
     */
    public function adminIndex()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $peminjamans = Peminjaman::with(['buku', 'siswa', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjaman.admin.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource for Siswa.
     */
    public function create()
    {
        $bukus = Buku::where('jumlah_stok', '>', 0)
            ->orderBy('judul_buku')
            ->get();

        return view('peminjaman.create', compact('bukus'));
    }

    /**
     * Show the form for creating a new resource for Admin.
     */
    public function adminCreate()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $bukus = Buku::where('jumlah_stok', '>', 0)
            ->orderBy('judul_buku')
            ->get();
        $siswas = User::where('role', 'siswa')
            ->orderBy('name')
            ->get();

        return view('peminjaman.admin.create', compact('bukus', 'siswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_wajib_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Determine siswa_user_id based on role
        if (Auth::user()->role === 'admin' && $request->filled('siswa_user_id')) {
            $siswaUserId = $request->siswa_user_id;
        } else {
            $siswaUserId = Auth::id();
        }

        // Check if the book is still available
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->jumlah_stok <= 0) {
            return back()->with('error', 'Stok buku sudah habis.');
        }

        // Check if siswa already has the same book borrowed and not returned
        $existingPeminjaman = Peminjaman::where('siswa_user_id', $siswaUserId)
            ->where('buku_id', $request->buku_id)
            ->where('status_peminjaman', 'Dipinjam')
            ->first();

        if ($existingPeminjaman) {
            return back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        $peminjaman = new Peminjaman();
        $peminjaman->siswa_user_id = $siswaUserId;
        $peminjaman->buku_id = $request->buku_id;
        $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
        $peminjaman->tanggal_wajib_kembali = $request->tanggal_wajib_kembali;
        $peminjaman->status_peminjaman = 'Dipinjam';

        // If admin creates the peminjaman, record the admin user ID
        if (Auth::user()->role === 'admin') {
            $peminjaman->admin_user_id = Auth::id();
        }

        $peminjaman->save();

        // Decrease book stock
        $buku->jumlah_stok -= 1;
        $buku->save();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('peminjaman.admin.index')->with('success', 'Peminjaman berhasil dicatat!');
        } else {
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        // Check if the user is authorized to edit this peminjaman
        if (Auth::user()->role !== 'admin' && $peminjaman->siswa_user_id !== Auth::id()) {
            return redirect()->route('peminjaman.index')->with('error', 'Anda tidak memiliki akses untuk mengedit peminjaman ini.');
        }

        // For admin, show the admin edit form
        if (Auth::user()->role === 'admin') {
            return view('peminjaman.admin.edit', compact('peminjaman'));
        }

        // For siswa, only allow editing if the status is still "Dipinjam"
        if ($peminjaman->status_peminjaman !== 'Dipinjam') {
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman yang sudah selesai tidak dapat diedit.');
        }

        $buku = $peminjaman->buku;
        return view('peminjaman.edit', compact('peminjaman', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Check if the user is authorized to update this peminjaman
        if (Auth::user()->role !== 'admin' && $peminjaman->siswa_user_id !== Auth::id()) {
            return redirect()->route('peminjaman.index')->with('error', 'Anda tidak memiliki akses untuk mengupdate peminjaman ini.');
        }

        // For admin, handle full update
        if (Auth::user()->role === 'admin') {
            $request->validate([
                'tanggal_pinjam' => 'required|date',
                'tanggal_wajib_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
                'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_pinjam',
                'status_peminjaman' => 'required|in:Dipinjam,Dikembalikan,Terlambat',
                'denda' => 'nullable|integer|min:0',
            ]);

            // Store old status for stock management
            $oldStatus = $peminjaman->status_peminjaman;
            $newStatus = $request->status_peminjaman;

            // Update peminjaman
            $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
            $peminjaman->tanggal_wajib_kembali = $request->tanggal_wajib_kembali;
            $peminjaman->tanggal_pengembalian = $request->tanggal_pengembalian;
            $peminjaman->status_peminjaman = $newStatus;
            $peminjaman->denda = $request->denda ?? 0;

            // If admin updates the peminjaman, record the admin user ID
            if (!$peminjaman->admin_user_id) {
                $peminjaman->admin_user_id = Auth::id();
            }

            $peminjaman->save();

            // Handle book stock based on status changes
            $buku = $peminjaman->buku;
            if ($oldStatus === 'Dipinjam' && $newStatus !== 'Dipinjam') {
                // Book is being returned
                $buku->jumlah_stok += 1;
            } elseif ($oldStatus !== 'Dipinjam' && $newStatus === 'Dipinjam') {
                // Book is being borrowed again
                $buku->jumlah_stok -= 1;
            }
            $buku->save();

            return redirect()->route('peminjaman.admin.index')->with('success', 'Peminjaman berhasil diperbarui!');
        }

        // For siswa, only allow updating return date
        if ($peminjaman->status_peminjaman !== 'Dipinjam') {
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman yang sudah selesai tidak dapat diubah.');
        }

        $request->validate([
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Update status to "Dikembalikan"
        $peminjaman->tanggal_pengembalian = $request->tanggal_pengembalian;

        // Calculate denda if late
        $wajibKembali = Carbon::parse($peminjaman->tanggal_wajib_kembali);
        $tanggalKembali = Carbon::parse($request->tanggal_pengembalian);

        if ($tanggalKembali->gt($wajibKembali)) {
            $daysDiff = $tanggalKembali->diffInDays($wajibKembali);
            $peminjaman->denda = $daysDiff * 1000; // Rp 1,000 per day
            $peminjaman->status_peminjaman = 'Terlambat';
        } else {
            $peminjaman->status_peminjaman = 'Dikembalikan';
        }

        $peminjaman->save();

        // Increase book stock when returned
        $buku = $peminjaman->buku;
        $buku->jumlah_stok += 1;
        $buku->save();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('peminjaman.index')->with('error', 'Anda tidak memiliki akses untuk menghapus peminjaman.');
        }

        // If the book is still borrowed, increase the stock when deleted
        if ($peminjaman->status_peminjaman === 'Dipinjam') {
            $buku = $peminjaman->buku;
            $buku->jumlah_stok += 1;
            $buku->save();
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.admin.index')->with('success', 'Peminjaman berhasil dihapus!');
    }

    /**
     * Generate PDF report for all peminjaman.
     */
    public function generatePdf()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk mencetak laporan.');
        }

        $peminjamans = Peminjaman::with(['buku', 'siswa', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('peminjaman.pdf', compact('peminjamans'));

        return $pdf->download('laporan-peminjaman-' . date('Y-m-d') . '.pdf');
    }
}
