<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class AdminPasswordConfirmController extends Controller
{
    // 管理者パスワード確認
    public function confirmPassword(Request $request) {
        $admin = \Auth::guard('admin')->user();
        if(!password_verify($request->current_password,$admin->password))
        {
            return response([
                'errorMessage' => 'パスワードが違います。'
            ], 422);
        }
    }
}
