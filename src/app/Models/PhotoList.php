<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PhotoList extends Model
{
    use HasFactory;

    public function photoList($request) {
        $photo_list = DB::table('photos')  // 主となるテーブル名
        ->select(
            'photos.id AS photo_id',
            'photos.admin_id',
            'photos.filename',
            'photos.price',
            'admins.id AS admin_id',
            'admins.name',
            'admins.email'
            )
        // 第一引数に結合するテーブル名、第二引数に主テーブルの結合キー、第四引数に結合するテーブルの結合キーを記述
        ->leftJoin('admins', 'admins.id', '=', 'photos.admin_id')
        ->where('admin_id', $request->id)
        ->get();

        return $photo_list;
    }
}
