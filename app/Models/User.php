<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // 1. Beritahu Laravel bahwa Primary Key kita adalah 'user_id', bukan 'id'
    protected $primaryKey = 'user_id'; // Pastikan baris ini ADA
    public $incrementing = true; // Atau false jika user_id bukan auto-increment
    protected $keyType = 'int';

    // 2. MATIKAN TIMESTAMPS AGAR TIDAK MENCARI updated_at & created_at
    public $timestamps = false;

    // 3. Beritahu Laravel kolom apa saja yang boleh diisi datanya secara langsung (Mass Assignment)
    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'google_id',
        'auth_provider',
        'role',
    ];

    // 4. Beritahu Laravel untuk menyembunyikan password saat data user diambil
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    // 5. Beritahu Laravel bahwa kolom password kita bernama 'password_hash'
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }
    // Di dalam class User
public function profile()
{
    return $this->hasOne(Profile::class, 'user_id', 'user_id');
}
}
