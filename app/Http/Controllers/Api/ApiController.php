<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function successReturn($data = [], $msg = 'ok')
    {
        return response()->json(compact('data', 'msg'), 200);
    }

    public function errorReturn($msg = '', $status = 400)
    {
        if ($msg === '') {
            switch ($status) {
                case 400:
                    $msg = 'request error';
                    break;
                case 500:
                    $msg = 'system error';
                    break;
                default:
                    $msg = 'error';
            }
        }

        return response()->json(compact('data', 'msg'), $status);
    }
}
