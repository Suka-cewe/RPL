<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $petugas = Petugas::with('user')->get();
        return view('petugas.index', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $users = User::where('role', 'admin')->whereDoesntHave('petugas')->get();
        return view('petugas.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Petugas::create($request->all());

        return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Petugas $petuga)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('petugas.show', compact('petuga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petugas $petuga)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $users = User::where('role', 'admin')
            ->where(function ($query) use ($petuga) {
                $query->whereDoesntHave('petugas')
                    ->orWhereHas('petugas', function ($q) use ($petuga) {
                        $q->where('id', $petuga->id);
                    });
            })
            ->get();

        return view('petugas.edit', compact('petuga', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petugas $petuga)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $petuga->update($request->all());

        return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petugas $petuga)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $petuga->delete();

        return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil dihapus!');
    }
}
