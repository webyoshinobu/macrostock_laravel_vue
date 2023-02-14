<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'new_password' => 'required|string|min:8|confirmed',
        ]);
    }

    public function update(Request $request)
    {

        $user = \Auth::user();
        if(!password_verify($request->current_password,$user->password))
        {
            // return redirect('/password/change')
            //     ->with('warning','パスワードが違います');
            return 'パスワードが違います';
        }

        //新規パスワードの確認
        $this->validator($request->all())->validate();

        $user->password = bcrypt($request->new_password);
        $user->save();

        // return redirect ('/')
        //     ->with('status','パスワードの変更が終了しました');

        return 'パスワードの変更が終了しました';
    }
}
