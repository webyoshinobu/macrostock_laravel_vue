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
        'admin_name',
        'admin_email',
        'admin_password',
    ];

    protected $hidden = [
        'admin_password',
        // 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
