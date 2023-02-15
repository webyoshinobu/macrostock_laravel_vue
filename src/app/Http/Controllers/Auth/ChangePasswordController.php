<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'new_password' =>  ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function update(Request $request)
    {

        $user = \Auth::user();
        if(!password_verify($request->current_password,$user->password))
        {
            // return redirect('/password/change')
            //     ->with('warning','パスワードが違います');
            // return response('現在のパスワードが違います', 422);
            return response([
                'errorCurrent' => '現在のパスワードが違います。'
            ], 422);
        }

        //新規パスワードの確認
        $this->validator($request->all())->validate();

        $user->password = bcrypt($request->new_password);
        $user->save();

        // return redirect ('/')
        //     ->with('status','パスワードの変更が終了しました');

        // return response('パスワードが正しく変更されました。', 200);
        return response([
            'changeSuccess' => 'パスワードが正しく変更されました。。'
        ], 200);
    }
}
