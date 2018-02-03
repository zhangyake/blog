<?php

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
//    return redirect('/articles');
//    博客前台页面
      return view('vue');
});

Route::middleware(['homeQuery'])->group(function () {

    Route::get('/articles', 'ArticleController@allArticles')->name('article_home_view');

    Route::get('/articles/{id}', 'ArticleController@index')->name('article_view');

    Route::get('/archives/type/{id}', 'TypeController@listArticles')->name('type_archives_view');

    Route::get('/archives/tag/{id}', 'TagController@listArticles')->name('tag_archives_view');

    Route::get('/archives', 'ArticleController@lists')->name('archives_view');

});

Route::get('/admin', function () {
//    博客后台页面
    return view('index');
});



