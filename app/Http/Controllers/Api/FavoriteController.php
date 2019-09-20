<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;

class FavoriteController extends ApiController
{
    /**
     * 分页查询.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $favorites = Favorite::latest()->paginate(10);

        return FavoriteResource::collection($favorites);
    }

    /**
     * 新增记录.
     *
     * @param FavoriteRequest $request
     *
     * @return FavoriteResource
     */
    public function store(FavoriteRequest $request)
    {
        $favorite = new Favorite();
        $favorite->fill($request->all());
        $favorite->save();

        return new FavoriteResource($favorite);
    }

    /**
     * 查看详情.
     *
     * @param $id
     *
     * @return FavoriteResource
     */
    public function show($id)
    {
        $favorite = Favorite::findOrFail($id);

        return new FavoriteResource($favorite);
    }

    /**
     * 更新.
     *
     * @param FavoriteRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(FavoriteRequest $request, $id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->fill($request->all());
        $favorite->save();

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
        Favorite::destroy($id);

        return $this->noContent();
    }
}
