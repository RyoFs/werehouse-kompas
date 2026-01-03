<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Alat extends Model
{
    use HasFactory;
    protected $table = 'alats';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_alat',
        'jenis_alat',
        'nama_alat',
        'persediaan_awal',
        'persediaan_gudang',
    ];

    // Relasi ke detail peminjaman
    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'kode_alat', 'kode_alat');
    }

    public function getSelisihAttribute()
    {
        return $this->persediaan_awal - $this->persediaan_gudang;
    }

    protected static function booted()
    {
        // Invalidate dashboard cache keys when alat diubah/hapus/ditambah
        static::saved(function ($model) {
            Cache::forget('dashboard.totalAlat');
        });

        static::deleted(function ($model) {
            Cache::forget('dashboard.totalAlat');
        });
    }
}
