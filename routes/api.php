<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/', function(){
//     return 'Hello World!';
// });

// 取得
Route::get('/getall','SavingsController@getAll');

// 登録
Route::post('/store','SavingsController@store');

// 更新
Route::post('/update','SavingsController@update');

//論理削除
Route::get('/delete/{id}', 'SavingsController@delete');