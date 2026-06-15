<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi_singkat',
        'target_donasi',
        'dana_terkumpul',
        'donatur_count',
        'progress_percentage',
        'gambar',
        'deadline',
        'status',
        'is_featured',
    ];

    public function donasis(): HasMany
    {
        return $this->hasMany(Donasi::class);
    }
}