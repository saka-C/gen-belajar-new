<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'google_id',
        'auth_provider',
        'role',
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Laravel akan memakai password_hash sebagai password.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'user_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
}