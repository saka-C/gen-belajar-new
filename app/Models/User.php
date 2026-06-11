<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $user_id
 * @property string $username
 * @property string $email
 * @property string|null $password_hash
 * @property string|null $google_id
 * @property string|null $auth_provider
 * @property string|null $role
 * 
 * @property Collection|Donation[] $donations
 * @property Profile|null $profile
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	protected $fillable = [
		'username',
		'email',
		'password_hash',
		'google_id',
		'auth_provider',
		'role'
	];

	public function donations()
	{
		return $this->hasMany(Donation::class);
	}

	public function profile()
	{
		return $this->hasOne(Profile::class);
	}
}
