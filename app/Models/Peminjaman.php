<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peminjamans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siswa_user_id',
        'buku_id',
        'admin_user_id',
        'tanggal_pinjam',
        'tanggal_wajib_kembali',
        'tanggal_pengembalian',
        'status_peminjaman',
        'denda',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_wajib_kembali' => 'date',
        'tanggal_pengembalian' => 'date',
    ];

    /**
     * Get the siswa that owns the peminjaman
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_user_id');
    }

    /**
     * Get the buku that is being borrowed
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Get the admin that processed the peminjaman
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
}
