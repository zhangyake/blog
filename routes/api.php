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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::post('me', 'Api\AuthController@me');
});

Route::middleware('auth:api')->group(function () {
    // Tag 相关接口
    Route::get('tags', 'Api\TagController@index');
    Route::get('tags/all', 'Api\TagController@all');
    Route::post('tags', 'Api\TagController@store');
    Route::get('tags/{id}', 'Api\TagController@show');
    Route::put('tags/{id}', 'Api\TagController@update');
    Route::delete('tags/{id}', 'Api\TagController@destroy');

    // Article 相关接口
    Route::get('articles', 'Api\ArticleController@index');
    Route::post('articles', 'Api\ArticleController@store');
    Route::get('articles/{id}', 'Api\ArticleController@show');
    Route::put('articles/{id}', 'Api\ArticleController@update');
    Route::delete('articles/{id}', 'Api\ArticleController@destroy');

    // Admin 相关接口
    Route::get('admins', 'Api\AdminController@index');
    Route::post('admins', 'Api\AdminController@store');
    Route::get('admins/{id}', 'Api\AdminController@show');
    Route::put('admins/{id}', 'Api\AdminController@update');
    Route::delete('admins/{id}', 'Api\AdminController@destroy');
});

// Area 相关接口
//查询所有区域信息id = 0 时 省市区信息
Route::get('areas/{id}', 'Api\AreaController@children');

// Comment 相关接口
Route::get('comments', 'Api\CommentController@index');
Route::post('comments', 'Api\CommentController@store');
Route::get('comments/{id}', 'Api\CommentController@show');
Route::put('comments/{id}', 'Api\CommentController@update');
Route::delete('comments/{id}', 'Api\CommentController@destroy');

// Reply 相关接口
Route::get('replies', 'Api\ReplyController@index');
Route::post('replies', 'Api\ReplyController@store');
Route::get('replies/{id}', 'Api\ReplyController@show');
Route::put('replies/{id}', 'Api\ReplyController@update');
Route::delete('replies/{id}', 'Api\ReplyController@destroy');

// Like 相关接口
Route::get('likes', 'Api\LikeController@index');
Route::post('likes', 'Api\LikeController@store');
Route::get('likes/{id}', 'Api\LikeController@show');
Route::put('likes/{id}', 'Api\LikeController@update');
Route::delete('likes/{id}', 'Api\LikeController@destroy');

// Favorite 相关接口
Route::get('favorites', 'Api\FavoriteController@index');
Route::post('favorites', 'Api\FavoriteController@store');
Route::get('favorites/{id}', 'Api\FavoriteController@show');
Route::put('favorites/{id}', 'Api\FavoriteController@update');
Route::delete('favorites/{id}', 'Api\FavoriteController@destroy');
