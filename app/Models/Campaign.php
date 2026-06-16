<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    protected $table = 'campaigns';
    protected $primaryKey = 'campaign_id';
    public $timestamps = false;

    protected $casts = [
        'target_amount' => 'float',
        'current_amount' => 'float',
        'is_pinned' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'description',
        'target_amount',
        'current_amount',
        'image',
        'status',
        'is_pinned',
    ];

    protected static function booted(): void
    {
        static::saving(function (Campaign $campaign) {

            if ($campaign->is_pinned) {

                DB::table('campaigns')
                    ->where('campaign_id', '!=', $campaign->campaign_id)
                    ->update([
                        'is_pinned' => false,
                    ]);
            }

        });
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class, 'campaign_id', 'campaign_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'campaign_id', 'campaign_id');
    }
}