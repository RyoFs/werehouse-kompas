<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans'; // 👈 tambahkan ini
    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'nama_peminjam',
        'status',
        'keterangan',
        'user_id',
    ];

    protected $dates = ['tanggal_pinjam', 'tanggal_kembali'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjamans_id');
    }

}
