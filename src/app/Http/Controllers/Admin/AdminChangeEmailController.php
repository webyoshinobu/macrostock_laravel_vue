<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AdminChangeEmailController extends Controller
{
    protected function validator(array $data, $admin)
    {
        return Validator::make($data,[
            'new_email' =>  [
                'required',
                'string',
                'email:filter,dns',
                'max:255',
                'confirmed',
                'unique:admins,email,'.$admin->id.',id', // 変更しようとしているユーザーの場合は除外
            ],
        ]);
    }

    public function update(Request $request)
    {
        $admin = \Auth::guard('admin')->user();
        if($request->current_email !== $admin->email)
        {
            return response([
                'errorCurrent' => '現在のメールアドレスが違います。'
            ], 422);
        }

        //新規メールアドレスの確認
        $this->validator($request->all(), $admin)->validate();

        //メールアドレスの変更を保存
        $admin->email = $request->new_email;
        $admin->save();

        return response([
            'changeSuccess' => 'メールアドレスが正しく変更されました。'
        ], 200);
    }
}
