<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Allocation
 *
 * @property int $allocation_id
 * @property int $campaign_id
 * @property string $metode   (cash|transfer|lainnya)
 * @property string $penerima
 * @property float $amount_used
 * @property string|null $description
 * @property Carbon $created_at
 *
 * @property Campaign $campaign
 *
 * @package App\Models
 */
class Allocation extends Model
{
    protected $table = 'allocations';
    protected $primaryKey = 'allocation_id';
    public $timestamps = false;

    protected $casts = [
        'campaign_id'  => 'int',
        'amount_used'  => 'float',
    ];

    protected $fillable = [
        'campaign_id',
        'metode',
        'penerima',
        'amount_used',
        'description',
        'created_at',
    ];

    /**
     * Boot: handle model observers for campaign status.
     */
    protected static function booted(): void
    {
        static::created(function (Allocation $allocation) {
            Campaign::where('campaign_id', $allocation->campaign_id)
                ->whereIn('status', ['completed', 'telah_disalurkan'])
                ->update(['status' => 'telah_disalurkan']);
        });

        static::deleted(function (Allocation $allocation) {
            $remaining = Allocation::where('campaign_id', $allocation->campaign_id)->exists();
            if (!$remaining) {
                Campaign::where('campaign_id', $allocation->campaign_id)
                    ->where('status', 'telah_disalurkan')
                    ->update(['status' => 'completed']);
            }
        });

        static::updated(function (Allocation $allocation) {
            if ($allocation->wasChanged('campaign_id')) {
                $oldCampaignId = $allocation->getOriginal('campaign_id');
                
                Campaign::where('campaign_id', $allocation->campaign_id)
                    ->whereIn('status', ['completed', 'telah_disalurkan'])
                    ->update(['status' => 'telah_disalurkan']);

                $remainingOld = Allocation::where('campaign_id', $oldCampaignId)->exists();
                if (!$remainingOld) {
                    Campaign::where('campaign_id', $oldCampaignId)
                        ->where('status', 'telah_disalurkan')
                        ->update(['status' => 'completed']);
                }
            }
        });
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'campaign_id');
    }
}
