<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    protected $fillable = [
        'message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); //ความสัมพันธ์นี้แสดงว่าในฐานข้อมูลตาราง chirps เพื่อเชื่อมโยงกับตาราง users
    }
}
