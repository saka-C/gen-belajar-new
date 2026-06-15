<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donasi extends Model
{
    protected $table = 'donations';

    protected $fillable = [
        'campaign_id',
        'donatur_id',
        'nominal',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function donatur(): BelongsTo
    {
        return $this->belongsTo(Donatur::class);
    }
}