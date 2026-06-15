<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donatur extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
    ];

    public function donasis(): HasMany
    {
        return $this->hasMany(Donasi::class);
    }
}