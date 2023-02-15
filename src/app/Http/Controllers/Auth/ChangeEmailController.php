<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ChangeEmailController extends Controller
{
    protected function validator(array $data)
    {
        // return Validator::make($data,[
        //     'new_email' =>  ['required', 'string', 'email', 'max:255', 'unique:users'],
        // ]);
        return Validator::make($data,[
            'new_email' =>  ['required', 'string', 'email:filter,dns', 'max:255', 'confirmed'],
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
        $this->validator($request->all())->validate();

        $user->email = $request->new_email;
        $user->save();

        return response([
            'changeSuccess' => 'メールアドレスが正しく変更されました。'
        ], 200);
    }
}
