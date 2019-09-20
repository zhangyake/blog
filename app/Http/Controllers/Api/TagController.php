<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Http\Resources\Tag\TagResource;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
class TagController extends ApiController
{

    public function all()
    {
        $tags = Tag::all();
        return TagResource::collection($tags);
    }

    /**
     * 分页查询
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $tags = Tag::latest()
                   ->paginate(10);
        return TagResource::collection($tags);
    }

    /**
     * 新增记录
     *
     * @param TagRequest $request
     * @return TagResource
     */
    public function store(TagRequest $request)
    {
        $tag = new Tag();
        $tag->fill($request->all());
        $tag->save();
        return new TagResource($tag);
    }

    /**
     * 查看详情
     *
     * @param $id
     * @return TagResource
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return new TagResource($tag);
    }

    /**
     * 更新
     *
     * @param TagRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->fill($request->all());
        $tag->save();
        return $this->noContent();
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);
        return $this->noContent();
    }
}