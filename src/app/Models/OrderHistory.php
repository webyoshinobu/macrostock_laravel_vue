<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderHistory extends Model
{
    use HasFactory;

    public function orderHistory($request) {
        $order_history = DB::table('orders')  // 主となるテーブル名
        ->select('orders.uuid', 'orders.user_id', 'orders.order_total_amount', 'orders.order_total_number', 'orders.created_at','order_details.filename', 'order_details.price', 'order_details.url', 'order_details.order_id', 'order_details.photo_id')
        // 第一引数に結合するテーブル名、第二引数に主テーブルの結合キー、第四引数に結合するテーブルの結合キーを記述
        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.uuid')
        ->where('user_id', $request->id)
        ->get();

        return $order_history;
    }
}
