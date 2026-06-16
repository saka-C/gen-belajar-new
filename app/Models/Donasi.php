<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donasi extends Model
{
    protected $table = 'donations';
    protected $primaryKey = 'donation_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'amount',
        'is_anonymous',
        'guest_name',
        'payment_method',
        'transaction_id',
        'payment_status',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'campaign_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function donatur(): BelongsTo
    {
        return $this->belongsTo(Donatur::class, 'user_id', 'user_id');
    }
}
