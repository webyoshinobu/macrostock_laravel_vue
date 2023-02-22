<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| ユーザー関連
|--------------------------------------------------------------------------
*/
// 会員登録
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register');
// ログイン
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
// ログアウト
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
// ログインユーザー
Route::get('/user', fn() => Auth::user())->name('user');
// パスワード変更
Route::post('/changePassword','App\Http\Controllers\Auth\ChangePasswordController@update')->name('changePassword');
// メールアドレス変更
Route::post('/changeEmail','App\Http\Controllers\Auth\ChangeEmailController@update')->name('changeEmail');
//注文
Route::post('/order','App\Http\Controllers\OrderController@create')->name('order');
//注文詳細
Route::post('/orderDetail','App\Http\Controllers\OrderDetailController@create')->name('orderDetail');
//注文一覧
Route::post('/orderHistory','App\Http\Controllers\OrderHistoryController@getOrderHistory')->name('orderHistory');
//PDF
Route::post('/orderHistoryPdf','App\Http\Controllers\PdfController@createPdf')->name('orderHistoryPdf');

/*
|--------------------------------------------------------------------------
| 管理者関連
|--------------------------------------------------------------------------
*/
// 会員登録
Route::post('/admin/register', 'App\Http\Controllers\Admin\RegisterController@register')->name('register');
// ログイン
Route::post('/admin/login', 'App\Http\Controllers\Admin\LoginController@login')->name('login');
// ログアウト
Route::post('/admin/logout', 'App\Http\Controllers\Admin\LoginController@logout')->name('logout');
// ログイン管理者
Route::get('/admin', fn() => Auth::guard('admin')->user())->name('admin');

/*
|--------------------------------------------------------------------------
| 写真関連
|--------------------------------------------------------------------------
*/
// 写真アップロード
Route::post('/photos', 'App\Http\Controllers\PhotoController@create')->name('photo.create');
// 写真一覧表示
Route::get('/gallery', 'App\Http\Controllers\PhotoController@index')->name('photo.index');
// //写真ダウンロード
// Route::get('/photos/zipDownLoad', 'App\Http\Controllers\PhotoController@zipDownLoad')->name('photo.zipDownLoad');
Route::post('/photos/zipDownLoad', 'App\Http\Controllers\PhotoController@zipDownLoad')->name('photo.zipDownLoad');

/*
|--------------------------------------------------------------------------
| トークンリフレッシュ
|--------------------------------------------------------------------------
*/
Route::get('/reflesh-token', function (Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();

    return response()->json();
});
