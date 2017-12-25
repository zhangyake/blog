<?php

namespace App\Http\Controllers\Api;


use App\Article;
use App\Tag;
use App\Type;

class AxiosController extends ApiController
{


    //  文章类别
    public function types()
    {
        $types = Type::all(['id', 'name']);
        return $this->successReturn(compact('types'));
    }

    // 文章标签
    public function tags()
    {
        $tags = Tag::with('articles')->get(['id', 'name']);
        return $this->successReturn(compact('tags'));
    }

    // 文章
    public function articles()
    {
        $data                     = Article::with('type')->orderBy('id','DESC')->paginate()->toArray();
        $articles['total']        = array_get($data, 'total');
        $articles['current_page'] = array_get($data, 'current_page');
        $articles['last_page']    = array_get($data, 'last_page');
        $articles['list']         = array_get($data, 'data');
        return $this->successReturn(compact('articles'));
    }


    public function articleDetail($id)
    {
        $article = Article::find($id);

        return $this->successReturn(compact('article'));
    }


}
