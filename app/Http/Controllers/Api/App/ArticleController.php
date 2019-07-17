<?php

namespace App\Http\Controllers\Api\App;


use App\Article;
use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\TagResource;
use App\Http\Resources\App\ArticleResource;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends ApiController
{
    //  文章类别
    public function categories()
    {
        $categories = Category::all(['id', 'name']);
        return CategoryResource::collection($categories);
    }

    // 文章标签
    public function tags()
    {
        $tags = Tag::withCount('articles')->get(['id', 'name']);
        return TagResource::collection($tags);
    }

    // 文章
    public function articles(Request $request)
    {
        $tagId = $request->input('tag_id');

        $query = Article::with(['category', 'tags']);
        if ($tagId) {
            $query->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            });
        }
        $data = $query->orderBy('id', 'DESC')->where('state',1)->paginate();


        return ArticleResource::collection($data);
    }


    public function articleDetail($id)
    {
        $article = Article::with(['type', 'tags'])->findOrFail($id);

        return new ArticleResource($article);
    }

    public function archives(Request $request)
    {
        $tagId = $request->input('tag_id');
        $query = Article::with(['type', 'tags']);
        if ($tagId) {
            $query->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            });
        }
        $data                     = $query->select(DB::raw("id,tag_id,title,created_at,DATE_FORMAT(`created_at`,'%M,%Y') as archives"))->orderBy('id', 'DESC')->paginate()->toArray();
        $articles['total']        = array_get($data, 'total');
        $articles['current_page'] = array_get($data, 'current_page');
        $articles['last_page']    = array_get($data, 'last_page');
        $articles['list']         = collect(array_get($data, 'data'))->groupBy('archives');
        return $this->successReturn(compact('articles'));
    }
}
