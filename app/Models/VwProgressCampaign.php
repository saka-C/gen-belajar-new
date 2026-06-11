<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VwProgressCampaign
 * 
 * @property int $campaign_id
 * @property string $title
 * @property float $target_amount
 * @property float|null $current_amount
 * @property float|null $progress_percentage
 *
 * @package App\Models
 */
class VwProgressCampaign extends Model
{
	protected $table = 'vw_progress_campaign';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'campaign_id' => 'int',
		'target_amount' => 'float',
		'current_amount' => 'float',
		'progress_percentage' => 'float'
	];

	protected $fillable = [
		'campaign_id',
		'title',
		'target_amount',
		'current_amount',
		'progress_percentage'
	];
}
