<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderDetailController extends Controller
{
    protected function create(Request $request)
    {
        Log::info('OrderDetailController create');

        return OrderDetail::create([
            'filename'=>$request['filename'],
            'order_total_number'=>$request['order_total_number'],
            'price'=>$request['price'],
            'url'=>$request['url'],
            'owner'=>$request['owner'],
            'order_id'=>$request['order_id'],
            'photo_id' => $request['id'],
        ]);
    }

    protected function registered(Request $request, $orderDetail)
    {
        return $orderDetail;
    }
}
