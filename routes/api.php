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
Route::post('/login', function (Request $request) {
    $data     = $request->all();
    $http     = new GuzzleHttp\Client;
    $response = $http->post(env("APP_URL") . 'oauth/token', [
        'form_params' => [
            'grant_type'    => 'password',
            'client_id'     => 4,
            'client_secret' => 'jjoJVSiOoie2GVaMnDlgpRudoV3K3t57XFgDQLTh',
            'username'      => 'jaak@126.com',
            'password'      => 'admin',
            'scope'         => '*',
        ],
    ]);
//return response()->json(['user'=>json_decode((string)$response->getBody(), true)]);
    return json_decode((string)$response->getBody(), true);
});

Route::middleware(['auth:api'])->namespace('Api')->group(function () {
//  当前登录用户信息
    Route::get('/userinfo', 'UserController@show');
//  用户列表
    Route::get('/users', 'UserController@index');
//  新增用户
    Route::post('/users', 'UserController@store');
//  修改用户信息
    Route::put('/users/{id}', 'UserController@update');

     //  文章类别名称
    Route::get('/types', 'TypeController@index');

    //  文章显示
    Route::get('/articles/{id}', 'ArticleController@show');
//  文章列表
    Route::get('/articles', 'ArticleController@index');
//  发布文章
    Route::post('/articles', 'ArticleController@store');
//  更新文章
    Route::put('/articles/{id}', 'ArticleController@update');


});
