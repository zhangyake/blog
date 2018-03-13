<?php

use Illuminate\Http\Request;
use Tonyski\NCMusic\Facades\NCMusic;


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
Route::get('music', function (Request $request) {

    $search = $request->input('s');
    $type   = $request->input('t');

    switch ($type) {
        case 'search':
            $result = NCMusic::search($search); //关键字搜索
            break;
        case 'artist':
            $result = NCMusic::artist($search); //歌手热门单曲
            break;
        case 'playlist':
            $result = NCMusic::playlist($search); //歌手热门单曲
            break;
        case 'url':
            $result = NCMusic::url($search); //歌曲地址获取
            break;
        case 'lyric':
            $result = NCMusic::lyric($search); //歌词解析
            break;
        case 'mv':
            $result = NCMusic::mv($search); //MV解析
            break;
        case 'album':
            $result = NCMusic::album($search); //专辑解析
            break;
        default:
            $result = NCMusic::search($search); //关键字搜索
    }
    return $result;
});


Route::namespace('Api')->group(function () {
    Route::get('vaptcha/challenge', 'VaptchaController@getChallenge');
    Route::get('vaptcha/downtime', 'VaptchaController@getDownTime');


    Route::get('/_articles', 'AxiosController@articles');
    Route::get('/_articles/{id}', 'AxiosController@articleDetail');
    Route::get('/_types', 'AxiosController@types');
    Route::get('/_tags', 'AxiosController@tags');
    Route::get('/_archives', 'AxiosController@archives');


});


Route::post('/login', function (Request $request) {
    $data     = $request->all();
    $http     = new GuzzleHttp\Client;
    $response = $http->post(env("APP_URL") . 'oauth/token', [
        'form_params' => [
            'grant_type'    => 'password',
            'client_id'     => env("CLIENT_ID"),
            'client_secret' => env("CLIENT_SECRET"),
            'username'      => array_get($data, 'username'),
            'password'      => array_get($data, 'password'),
            'scope'         => '*',
        ],
    ]);
//return response()->json(['user'=>json_decode((string)$response->getBody(), true)]);
    return json_decode((string)$response->getBody(), true);
})->name('login');

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

    //  文章信息
    Route::get('/articles/{id}', 'ArticleController@detail');
//  文章列表
    Route::get('/articles', 'ArticleController@index');
//  发布文章
    Route::post('/articles', 'ArticleController@store');
//  更新文章
    Route::put('/articles/{id}', 'ArticleController@update');

//  退出登录
    Route::post('/logout', function (Request $request) {
        $res = \Laravel\Passport\Token::where('user_id', $request->user()->id)->update(['revoked' => 1]);
        return response()->json(['data' => $res]);
    });
});
//http://ip.taobao.com/instructions.html
Route::get('/robot', function (Request $request) {
    $data     = $request->all();
    $http     = new GuzzleHttp\Client;
    $response = $http->post(env("ROBOT_URL", 'http://www.tuling123.com/openapi/api'), [
        'json' => [
            'key'    => env("ROBOT_KEY", '0ee53f65c46a4206a5b049f1eda674c8'),
            'info'   => array_get($data, 'info', '你好!'),
            'userid' => array_get($data, 'id')
        ],
    ]);
    $status   = $response->getStatusCode();
    if ($status === 200) {
        $result = (string)$response->getBody();
        $array  = json_decode($result, true);
//        $code   = array_get($array, 'code');
//        $data = array_get($array,'text','');
//        switch ($code) {
////  文本类
//            case 100000:
//                break;
////	链接类
//            case 200000:
//                $data = array_get($array,'url','');
//                break;
////  新闻类
//            case 302000:
//                $data = array_get($array,'list','');
//                break;
////   菜谱类
//            case 308000:
//                $data = array_get($array,'list','');
//                break;
////   儿童版）	儿歌类
//            case 313000:
//                break;
////   儿童版）	诗词类
//            case 314000:
//                break;
////参数key错误
//            case 40001:
//                $data = '参数key错误';
//                break;
// //请求内容info为空
//            case 40002:
//                $data = '请求内容info为空';
//                break;
// //当天请求次数已使用完
//            case 40004:
//                $data = '当天请求次数已使用完';
//                break;
////数据格式异常
//            case 40007:
//                $data = '数据格式异常';
//                break;
//        }
        return response()->json($array);
    }
    return response()->json(['success' => false, 'reason' => '抱歉, 系统繁忙!']);

});