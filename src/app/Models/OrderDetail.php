<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'order_total_number',
        'price',
        'url',
        'owner',
        'order_id',
        'photo_id',
    ];

    protected $hidden = [
        'id'
    ];
}
