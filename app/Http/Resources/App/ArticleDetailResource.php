<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Resources\Json\Resource;

class ArticleDetailResource extends Resource
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
            'id' => $this->id,
            'title' => $this->title,
            'user_name' => $this->user->name,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'tags' => $this->tags,
            'page_view' => $this->page_view,
            'page_image_url' => $this->page_image_url,
            'state' => $this->state,
            'state_txt' => $this->state_txt,
            'content_md' => $this->content_md,
            'created_at' => $this->created_at,
        ];
    }
}
