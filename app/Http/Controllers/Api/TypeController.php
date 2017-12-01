<?php

namespace App\Http\Controllers\Api;


use App\Type;

class TypeController extends ApiController
{


//  文章类别
    public function index()
    {
        $types = Type::all(['id','name']);
        return $this->successReturn(compact('types'));
    }






}
