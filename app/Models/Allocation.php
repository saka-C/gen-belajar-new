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
 * @property string $category
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
		'campaign_id' => 'int',
		'amount_used' => 'float'
	];

	protected $fillable = [
		'campaign_id',
		'category',
		'amount_used',
		'description'
	];

	public function campaign()
	{
		return $this->belongsTo(Campaign::class);
	}
}
