<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class AdminDeleteAccountController extends Controller
{
    // 管理者アカウント削除
    public function destroy(Request $request) {
        $admin = $request->admin;
        $photos = $request->photos;
        $photo_filenames = [];
        $photo_filenames = array_column($photos, 'filename');
        Log::debug(print_r($admin, true));
        Log::debug(print_r($photos, true));
        Log::debug(print_r($photo_filenames, true));
        // s3の写真データ削除
        Storage::disk('s3')->delete($photo_filenames);
        // 管理者データと写真データをデータベースから削除
        Admin::destroy($admin);
    }
}
