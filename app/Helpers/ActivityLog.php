<?php

namespace App\Helpers;

use App\Models\Log;

class ActivityLog
{
    public static function add($aktivitas)
    {
        Log::create([
            'aktivitas' => $aktivitas,
            'waktu'     => now('Asia/Jakarta'),
            'user_id'   => auth()->id(),
        ]);
    }
}
