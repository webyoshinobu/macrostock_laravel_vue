<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'order_total_amount',
        'order_total_number',
    ];

    protected $hidden = [
        'id'
    ];

    // protected $visible = [
    //     'user_id', 'order_total_amount', 'order_total_number'
    // ];
}
