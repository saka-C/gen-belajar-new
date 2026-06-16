<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Donatur extends User
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    // Temporary storage for profile attributes
    protected array $tempProfileData = [];

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'google_id',
        'auth_provider',
        'role',
        'nama',
        'telepon',
        'alamat',
    ];

    protected static function booted()
    {
        static::addGlobalScope('donatur_role', function (Builder $builder) {
            $builder->where('role', 'donatur');
        });

        static::creating(function ($model) {
            $model->role = 'donatur';
            if (empty($model->username) && !empty($model->email)) {
                $model->username = explode('@', $model->email)[0];
            }
            if (empty($model->password_hash)) {
                $model->password_hash = \Illuminate\Support\Facades\Hash::make('password123');
            }
        });

        static::saved(function ($model) {
            if (!empty($model->tempProfileData)) {
                $model->profile()->updateOrCreate([], $model->tempProfileData);
                $model->tempProfileData = []; // Clear after saving
            }
        });
    }

    public function getNamaAttribute()
    {
        return $this->tempProfileData['full_name'] ?? ($this->profile->full_name ?? $this->username);
    }

    public function setNamaAttribute($value)
    {
        $this->tempProfileData['full_name'] = $value;
    }

    public function getTeleponAttribute()
    {
        return $this->tempProfileData['phone_number'] ?? ($this->profile->phone_number ?? null);
    }

    public function setTeleponAttribute($value)
    {
        $this->tempProfileData['phone_number'] = $value;
    }

    public function getAlamatAttribute()
    {
        return $this->tempProfileData['address'] ?? ($this->profile->address ?? null);
    }

    public function setAlamatAttribute($value)
    {
        $this->tempProfileData['address'] = $value;
    }
}
