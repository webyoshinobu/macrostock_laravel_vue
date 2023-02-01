<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

// class Admin extends Model
class Admin extends User
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    * リレーションシップ - photosテーブル
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function photos()
    {
        return $this->hasMany('App\Models\Photo');
    }
}
