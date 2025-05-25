<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Petugas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'petugas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_petugas',
        'jabatan',
        'kontak',
        'user_id',
    ];

    /**
     * Get the user associated with this petugas
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
