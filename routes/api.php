<?php

use App\Mail\OrderShipped;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tonyski\NCMusic\Facades\NCMusic;
use Illuminate\Support\Facades\Redis;

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

Route::get('free_books', function (Request $request) {
 $data = \App\FreeBook::where('is_show','1')->get();
 return response()->json(compact('data'), 200);
});
Route::post('free_books', function (Request $request) {
    $inputs = $request->all();
    $freeBookId = array_get($inputs,'free_book_id');
    $freeBook = \App\FreeBook::where('is_show','1')->where('status',1)->where('id',$freeBookId)->first();

    if( $freeBook && array_get($inputs,'user_name') && array_get($inputs,'address') && array_get($inputs,'mobile')){
        \DB::beginTransaction();
        try {
            $bookReceiver = new \App\BookReceiver();
            $bookReceiver->free_book_id = $freeBookId;
            $bookReceiver->user_name = array_get($inputs,'user_name');
            $bookReceiver->address = array_get($inputs,'address');
            $bookReceiver->mobile = array_get($inputs,'mobile');
            $bookReceiver->save();
            $freeBook->status = 2;
            $freeBook->save();
            // 发送提醒发货邮件
	        Mail::to('337141794@qq.com')->send(new OrderShipped($bookReceiver));

	        \DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::INFO($e->getMessage());
            return response()->json(['msg'=>'服务繁忙!'], 500);

        }
        return response()->json(compact('data'), 200);

    }
    return response()->json(['msg'=>'参数错误'], 400);

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


//Route::post('/login', function (Request $request) {
//    $data     = $request->all();
//    $http     = new GuzzleHttp\Client;
//    $response = $http->post(env("APP_URL") . 'oauth/token', [
//        'form_params' => [
//            'grant_type'    => 'password',
//            'client_id'     => env("CLIENT_ID"),
//            'client_secret' => env("CLIENT_SECRET"),
//            'username'      => array_get($data, 'username'),
//            'password'      => array_get($data, 'password'),
//            'scope'         => '*',
//        ],
//    ]);
////return response()->json(['user'=>json_decode((string)$response->getBody(), true)]);
//    return json_decode((string)$response->getBody(), true);
//})->name('login');

//后台登录
Route::post('auth/login', 'Api\Admin\AuthController@login');

// 获取返回图片验证码
Route::get('/captcha/{uuid}', function(Request $request, $uuid) {
    $builder = new  CaptchaBuilder();
    $builder->setIgnoreAllEffects(true)->build(100, 30);
    $code = $builder->getPhrase();
    Redis::setex($uuid, 180, $code); // 180s 存活时间
    return response($builder->output(280))->header('Content-type', 'image/jpeg');
});


Route::middleware([])->namespace('Api\Admin')->group(function () {

    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/refresh', 'AuthController@refresh');
    Route::post('auth/me', 'AuthController@me');
    Route::put('auth/reset', 'AuthController@resetPassword');



//  当前登录用户信息
    Route::get('/userinfo', 'UserController@show');
//  用户列表
    Route::get('/users', 'UserController@index');
//  新增用户
    Route::post('/users', 'UserController@store');
//  修改用户信息
    Route::put('/users/{id}', 'UserController@update');

    //  标签列表
    Route::get('/tags', 'TagController@index');
    //  新增标签
    Route::post('/tags', 'TagController@store');
    //  编辑标签
    Route::put('/tags/{id}', 'TagController@update');

    //  分类列表
    Route::get('/categories', 'CategoryController@index');
    //  新增分类
    Route::post('/categories', 'CategoryController@store');
    //  编辑分类
    Route::put('/categories/{id}', 'CategoryController@update');


    //  文章信息
    Route::get('/articles/{id}', 'ArticleController@detail');
    //  文章列表
    Route::get('/articles', 'ArticleController@index');
    //  发布文章
    Route::post('/articles', 'ArticleController@store');
    //  更新文章
    Route::put('/articles/{id}', 'ArticleController@update');
    //  更新文章
    Route::put('/articles/{id}/state', 'ArticleController@updateState');
//  退出登录
    Route::post('/logout', function (Request $request) {
        $res = \Laravel\Passport\Token::where('user_id', $request->user()->id)->update(['revoked' => 1]);
        return response()->json(['data' => $res]);
    });
});

Route::get('/ip', function (Request $request) {
    $ip = $request->getClientIp();
//    $ip='180.162.245.209';
    try {
        $http = new GuzzleHttp\Client;
        $response = $http->get(env("GAODE_IP_URL", 'https://restapi.amap.com/v3/ip').'?ip='.$ip.'&output=json&key=26af63ed8ca12da1c7fa64098eacdbe5');
        $status   = $response->getStatusCode();
        if ($status === 200) {
            $result = (string)$response->getBody();
            $array  = json_decode($result, true);
           if ($array['status'] == 1){
               $visit = new \App\Visit();
               $visit->fill($array)->save();
               return response()->json(['success' => true, 'reason' => '']);
           }else{
               \Log::info($ip);
           }
        }
    } catch (Exception $e) {
        \Log::error($ip);
        \Log::info($e->getMessage());
    }
    return response()->json(['success' => false, 'reason' => '抱歉, 系统繁忙!']);
});

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