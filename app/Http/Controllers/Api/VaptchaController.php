<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vaptcha\Vaptcha;

class VaptchaController extends Controller
{
    private $vaptcha;

    public function __construct(){
        $this->vaptcha = new Vaptcha('5a3b4dc2a48611214c68509a', '6b53108829334381ae355e2f75388f11'); // 这里替换成前面获取到的vid与key
    }

    public function response($status, $msg, $data){
        return response()->json([
            'status' =>  $status,
            'msg' => $msg,
            'data' => $data
        ], $status);
    }

    public function responseSuccess($data){
        return $this->response(200, 'success', $data);
    }

    public function getChallenge(Request $request){
        $data = json_decode($this->vaptcha->getChallenge($request->sceneid));
        return $this->responseSuccess($data);
    }

    public function getDownTime(Request $request) {
        $data = json_decode($this->vaptcha->downTime($request->data));
        return response()->json($data);
    }
}
