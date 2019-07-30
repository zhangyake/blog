<?php

namespace App\Http\Controllers\Api\App;

use App\Article;
use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\TagResource;
use App\Http\Resources\App\ArticleArchiveCollection;
use App\Http\Resources\App\ArticleDetailResource;
use App\Http\Resources\App\ArticleResource;
use App\Tag;
use Illuminate\Http\Request;


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
        $data = $query->orderBy('id', 'DESC')->where('state', 1)->paginate();

        return ArticleResource::collection($data);
    }

    public function articleDetail($id)
    {
        $article = Article::with(['category', 'tags'])->findOrFail($id);

        return new ArticleDetailResource($article);
    }

    public function archives(Request $request)
    {
        $tagId = $request->input('tag_id');
        $query = Article::with(['tags']);
        if ($tagId) {
            $query->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            });
        }
        $data = $query->select('id','title','state','created_at')->orderBy('created_at','DESC')->paginate();

        // collection 内部再次处理
        return new ArticleArchiveCollection($data);
    }
}
