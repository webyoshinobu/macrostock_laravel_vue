<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;

class AdminChangePasswordController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'new_password' =>  ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function update(Request $request)
    {

        $admin = \Auth::guard('admin')->user();
        if(!password_verify($request->current_password,$admin->password))
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

        $admin->password = bcrypt($request->new_password);
        $admin->save();

        // return redirect ('/')
        //     ->with('status','パスワードの変更が終了しました');

        // return response('パスワードが正しく変更されました。', 200);
        return response([
            'changeSuccess' => 'パスワードが正しく変更されました。'
        ], 200);
    }
}
