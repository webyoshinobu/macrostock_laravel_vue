<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{
    public function getOrderHistory(Request $request) {

        $order_history_model = new OrderHistory;
        $order_history_list = $order_history_model->orderHistory($request);
        return $order_history_list;
    }
}
