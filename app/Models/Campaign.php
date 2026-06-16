<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Campaign
 * 
 * @property int $campaign_id
 * @property string $title
 * @property string $description
 * @property float $target_amount
 * @property float|null $current_amount
 * @property string|null $image
 * @property string|null $status
 * @property Collection|Allocation[] $allocations
 * @property Collection|Donation[] $donations
 *
 * @package App\Models
 */
class Campaign extends Model
{
	protected $table = 'campaigns';
	protected $primaryKey = 'campaign_id';
	public $timestamps = false;

	protected $casts = [
		'target_amount' => 'float',
		'current_amount' => 'float'
	];

	protected $fillable = [
		'title',
		'description',
		'target_amount',
		'current_amount',
		'image',
		'status'
	];

	public function allocations()
	{
		return $this->hasMany(Allocation::class, 'campaign_id', 'campaign_id');
	}

	public function donations()
	{
		return $this->hasMany(Donation::class, 'campaign_id', 'campaign_id');
	}
}
