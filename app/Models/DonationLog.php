<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DonationLog
 * 
 * @property int $log_id
 * @property int $donation_id
 * @property string $deleted_at
 *
 * @package App\Models
 */
class DonationLog extends Model
{
	use SoftDeletes;
	protected $table = 'donation_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;

	protected $casts = [
		'donation_id' => 'int'
	];

	protected $fillable = [
		'donation_id'
	];
}
