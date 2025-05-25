<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::orderBy('judul_buku')->get();
        return view('buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk menambah buku.');
        }

        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk menambah buku.');
        }

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20|unique:bukus,isbn',
            'kategori' => 'nullable|string|max:50',
            'jumlah_stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk mengedit buku.');
        }

        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk mengedit buku.');
        }

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20|unique:bukus,isbn,' . $buku->id,
            'kategori' => 'nullable|string|max:50',
            'jumlah_stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('buku.index')->with('error', 'Anda tidak memiliki akses untuk menghapus buku.');
        }

        // Cek apakah buku sedang dipinjam
        if ($buku->peminjaman()->where('status_peminjaman', 'Dipinjam')->exists()) {
            return redirect()->route('buku.index')->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam.');
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
