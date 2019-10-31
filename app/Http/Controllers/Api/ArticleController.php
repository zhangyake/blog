<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;

class ArticleController extends ApiController
{
    /**
     * 分页查询.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $articles = Article::with('user')->select('id', 'user_id', 'title', 'created_at', 'status', 'like_count', 'comment_count', 'read_count')->latest()->paginate(10);

        return ArticleResource::collection($articles);
    }

    /**
     * 新增记录.
     *
     * @param ArticleRequest $request
     *
     * @return ArticleResource
     */
    public function store(ArticleRequest $request)
    {
//        $article = new Article();
//        $article->fill(array_merge($request->only(['title','preview','content','status']),['user_id'=>$request->user()->id]));
//        $article->save();

        $data = $request->only(['title', 'preview', 'content', 'content_md', 'status']);
        $article = $request->user()->articles()->create($data);
        $article->tags()->sync($request->input('tags'));

        return new ArticleResource($article);
    }

    /**
     * 查看详情.
     *
     * @param $id
     *
     * @return ArticleResource
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return new ArticleResource($article);
    }

    /**
     * 更新.
     *
     * @param ArticleRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->fill($request->only(['title', 'preview', 'content', 'status']));
        $article->save();
        $article->tags()->sync($request->input('tags'));

        return $this->noContent();
    }

    /**
     * 删除.
     *
     * @param Article $article id
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->tags()->sync([]);
        $article->delete();

        return $this->noContent();
    }
}
