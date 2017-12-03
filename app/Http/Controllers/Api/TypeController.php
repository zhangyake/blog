<?php

namespace App\Http\Controllers\Api;


use App\Tag;
use App\Type;

class TypeController extends ApiController
{


//  文章类别 文章标签列表
    public function index()
    {
        $types = Type::all(['id','name']);
        $tags = Tag::all(['id','name']);
        return $this->successReturn(compact('types','tags'));
    }






}
