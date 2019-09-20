<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Like\LikeResource;
use App\Http\Requests\LikeRequest;
use App\Models\Like;

class LikeController extends ApiController
{
    /**
     * 分页查询.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $likes = Like::latest()->paginate(10);

        return LikeResource::collection($likes);
    }

    /**
     * 新增记录.
     *
     * @param LikeRequest $request
     *
     * @return LikeResource
     */
    public function store(LikeRequest $request)
    {
        $like = new Like();
        $like->fill($request->all());
        $like->save();

        return new LikeResource($like);
    }

    /**
     * 查看详情.
     *
     * @param $id
     *
     * @return LikeResource
     */
    public function show($id)
    {
        $like = Like::findOrFail($id);

        return new LikeResource($like);
    }

    /**
     * 更新.
     *
     * @param LikeRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(LikeRequest $request, $id)
    {
        $like = Like::findOrFail($id);
        $like->fill($request->all());
        $like->save();

        return $this->noContent();
    }

    /**
     * 删除.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Like::destroy($id);

        return $this->noContent();
    }
}
