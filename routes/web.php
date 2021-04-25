<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'admin',
    // ログイン画面にリダイレクトされるよう設定 
    'middleware' => 'auth'
], 
function()
{
    // 第一引数：アドレス、第二引数：アドレスで呼び出される処理
    Route::get('news/create', 'App\Http\Controllers\Admin\NewsController@add');
    Route::post('news/create', 'App\Http\Controllers\Admin\NewsController@create');
    Route::get('news', 'App\Http\Controllers\Admin\NewsController@index');
    Route::get('news/edit', 'App\Http\Controllers\Admin\NewsController@edit');
    Route::post('news/edit', 'App\Http\Controllers\Admin\NewsController@update');
    Route::get('news/delete', 'App\Http\Controllers\Admin\NewsController@delete');

    Route::get('profile/create', 'App\Http\Controllers\Admin\ProfileController@add');
    Route::post('profile/create', 'App\Http\Controllers\Admin\ProfileController@create');
    Route::get('profile', 'App\Http\Controllers\Admin\ProfileController@show');
    Route::get('profile/edit', 'App\Http\Controllers\Admin\ProfileController@edit');
    Route::post('profile/edit', 'App\Http\Controllers\Admin\ProfileController@update');
    Route::get('profile/delete', 'App\Http\Controllers\Admin\ProfileController@delete');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', 'App\Http\Controllers\NewsController@index');