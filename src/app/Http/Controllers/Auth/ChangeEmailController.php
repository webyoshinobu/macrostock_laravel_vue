<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ChangeEmailController extends Controller
{
    protected function validator(array $data, $user)
    {
        // return Validator::make($data,[
        //     'new_email' =>  ['required', 'string', 'email', 'max:255', 'unique:users'],
        // ]);
        // Log::debug(print_r($data, true));
        // Log::debug(print_r($user, true));
        return Validator::make($data,[
            'new_email' =>  [
                'required',
                'string',
                'email:filter,dns',
                'max:255',
                'confirmed',
                // 'unique:users,email', //メールアドレスの重複チェック
                'unique:users,email,'.$user->id.',id', // 変更しようとしているユーザーの場合は除外
                // Rule::unique('users')->ignore($user->id ?? null, 'id'),
            ],
        ]);
    }

    public function update(Request $request)
    {

        // $user = \Auth::user();
        // if(!password_verify($request->current_password,$user->password))
        // {
        //     return response([
        //         'errorCurrent' => '現在のメールアドレスが違います。'
        //     ], 422);
        // }

        // //新規メールアドレスの確認
        // $this->validator($request->all())->validate();

        // $user->password = bcrypt($request->new_password);
        // $user->save();

        $user = \Auth::user();
        if($request->current_email !== $user->email)
        {
            return response([
                'errorCurrent' => '現在のメールアドレスが違います。'
            ], 422);
        }

        //新規メールアドレスの確認
        $this->validator($request->all(), $user)->validate();

        //メールアドレスの変更を保存
        $user->email = $request->new_email;
        $user->save();

        return response([
            'changeSuccess' => 'メールアドレスが正しく変更されました。'
        ], 200);
    }
}
