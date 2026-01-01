<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_details';

    protected $fillable = [
        'peminjamans_id',
        'kode_alat',
        'nama_alat',
        'qty_dipinjam',
    ];

    /**
     * Relasi ke tabel peminjamans (parent transaction)
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjamans_id');
    }

    /**
     * OPTIONAL: relasi ke tabel alat (kalau mau)
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'kode_alat', 'kode_alat');
    }
}
