<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DeleteAccountController extends Controller
{
    // ユーザー削除前パスワード確認
    public function confirmPassword(Request $request) {
        $user = \Auth::user();
        if(!password_verify($request->current_password,$user->password))
        {
            return response([
                'errorMessage' => 'パスワードが違います。'
            ], 422);
        }
    }

    // ユーザー削除
    public function destroy(Request $request) {
        $data = $request->all();
        Log::debug(print_r($data, true));
        // ユーザー削除
        User::destroy($data);
        // return redirect('/');
    }
}
