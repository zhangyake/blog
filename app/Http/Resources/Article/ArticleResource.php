<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'author' => [
                'avatar'=>$this->user->avatar
            ],
            'comment_count' => $this->comment_count,
            'created_at' => $this->created_at,
            'id' => $this->id,
            'like_count' => $this->like_count,
            'read_count' => $this->read_count,
            'status' => $this->status,
            'content' => $this->content,
            'title' => $this->title,
            'comments'=>$this->comments
        ];
    }
}
