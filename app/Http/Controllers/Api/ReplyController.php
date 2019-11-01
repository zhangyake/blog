<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Reply\ReplyResource;
use App\Http\Requests\ReplyRequest;
use App\Models\Comment;
use App\Models\Reply;

class ReplyController extends ApiController
{
    /**
     * 分页查询.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $replies = Reply::latest()->paginate(10);

        return ReplyResource::collection($replies);
    }

    /**
     * 新增记录.
     *
     * @param ReplyRequest $request
     * @param Comment      $comment
     *
     * @return ReplyResource
     */
    public function storeCommentReplay(ReplyRequest $request, Comment $comment)
    {
        $reply = $request->all();
        $reply->user_id = auth('api')->id;
        $reply->like_count = 0;
        $comment->replys()->create($reply);

        return new ReplyResource($reply);
    }

    /**
     * 查看详情.
     *
     * @param $id
     *
     * @return ReplyResource
     */
    public function show($id)
    {
        $reply = Reply::findOrFail($id);

        return new ReplyResource($reply);
    }

    /**
     * 更新.
     *
     * @param ReplyRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ReplyRequest $request, $id)
    {
        $reply = Reply::findOrFail($id);
        $reply->fill($request->all());
        $reply->save();

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
        Reply::destroy($id);

        return $this->noContent();
    }
}
