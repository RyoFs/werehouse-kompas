<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'aktivitas',
        'waktu',
        'user_id',
    ];

    public $timestamps = false; // 👈 Laravel tidak akan cari created_at lagi

    protected $table = 'logs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
