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

/*
|--------------------------------------------------------------------------
| 管理者関連
|--------------------------------------------------------------------------
*/
Route::post('/admin/login', [App\Http\Controllers\admin\LoginController::class, 'login']);
Route::post('/admin/logout', [App\Http\Controllers\admin\LoginController::class,'logout']);
// Route::post('/admin/register', [App\Http\Controllers\admin\RegisterController::class, 'register']);
Route::post('/admin/register', 'App\Http\Controllers\admin\RegisterController@register')->name('register');
