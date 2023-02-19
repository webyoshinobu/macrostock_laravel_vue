<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected function create(Request $request)
    {
        Log::info('OrderController create');

        return Orders::create([
            'uuid'=>(string) Str::uuid(),
            'user_id' => $request['user_id'],
            'order_total_amount' => $request['order_total_amount'],
            'order_total_number' => $request['order_total_number'],
        ]);
    }

    protected function registered(Request $request, $order)
    {
        return $order;
    }
}
