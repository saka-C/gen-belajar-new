<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VwDonasiSukse
 * 
 * @property int $donation_id
 * @property string $username
 * @property string $title
 * @property float $amount
 *
 * @package App\Models
 */
class VwDonasiSukse extends Model
{
	protected $table = 'vw_donasi_sukses';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'donation_id' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'donation_id',
		'username',
		'title',
		'amount'
	];
}
