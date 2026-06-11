<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * 
 * @property int $profile_id
 * @property int $user_id
 * @property string|null $full_name
 * @property string|null $phone_number
 * @property string|null $profile_picture_url
 * @property string|null $address
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Profile extends Model
{
	protected $table = 'profiles';
	protected $primaryKey = 'profile_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'full_name',
		'phone_number',
		'profile_picture_url',
		'address'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
