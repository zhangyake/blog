<?php

namespace App\Http\Controllers\Api\Admin;
use App\Article;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\ArticleResource;
use Illuminate\Http\Request;
class ArticleController extends ApiController
{

    //  文章列表
    public function index()
    {
        $name  = request('name');
        $state = request('state');
        $data  = Article::with('user')
                        ->when($name !== null, function ($query) use ($name) {
                            $query->where('name', 'like', '%' . $name . '%');
                        })
                        ->when($state !== null, function ($query) use ($state) {
                            $query->where('state', $state);
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        return ArticleResource::collection($data);
    }

    public function detail($id)
    {
        $article = Article::with('category', 'tags')
                          ->findOrFail($id);
        return new ArticleResource($article);
    }

    //  发布文章

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $this->reqValidate($request, [
            'title'          => 'required',
            'content'        => 'required',
            'content_md'     => 'required',
            'page_image_url' => 'required',
            'user_id'        => 'required',
            'category_id'    => 'required|exists:categories,id',
            'state'          => 'required'
        ]);
        $data    = $request->input();
        $article = new Article();
        $article->fill($data);
        $article->save();
        $article->tags()
                ->sync($request->get('tags'));
        return response()->json();
    }

    //  修改文章
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $this->reqValidate($request, [
            'title'          => 'required',
            'content'        => 'required',
            'content_md'     => 'required',
            'page_image_url' => 'required',
            'user_id'        => 'required',
            'category_id'    => 'required|exists:categories,id',
            'state'          => 'required'
        ]);
        $data = $request->all();
        $article->update($data);
        $article->tags()
                ->sync($request->get('tags'));
        return response()->json();
    }

    //  修改文章State
    public function updateState(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $this->reqValidate($request, [
            'state' => 'required|in:0,1,2'
        ]);
        $data = $request->only('state');
        $article->update($data);
        return response()->json();
    }

}
