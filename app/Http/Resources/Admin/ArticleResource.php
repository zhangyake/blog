<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class ArticleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'user_id'=>$this->user_id,
            'category_id'=>$this->category_id,
            'page_view'=>$this->page_view,
            'state'=>$this->state,
            'state_txt'=>$this->state_txt,
        ];
    }
}
