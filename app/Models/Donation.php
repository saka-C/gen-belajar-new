<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Donation
 * 
 * @property int $donation_id
 * @property int|null $user_id
 * @property int $campaign_id
 * @property float $amount
 * @property bool|null $is_anonymous
 * @property string|null $guest_name
 * @property string|null $payment_method
 * @property string $transaction_id
 * @property string|null $message
 * @property string|null $payment_status
 * 
 * @property User|null $user
 * @property Campaign $campaign
 *
 * @package App\Models
 */
class Donation extends Model
{
	protected $table = 'donations';
	protected $primaryKey = 'donation_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'campaign_id' => 'int',
		'amount' => 'float',
		'is_anonymous' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'campaign_id',
		'amount',
		'is_anonymous',
		'guest_name',
		'message',
		'payment_method',
		'transaction_id',
		'snap_token',
		'snap_redirect_url',
		'payment_status'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'user_id');
	}

	public function campaign()
	{
		return $this->belongsTo(Campaign::class, 'campaign_id', 'campaign_id');
	}
}
