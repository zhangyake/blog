<?php

namespace App\Http\Resources\App;

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
            'user_name'=>$this->user->name,
            'category_id'=>$this->category_id,
            'page_view'=>$this->page_view,
            'page_image_url'=>$this->page_image_url,
            'state'=>$this->state,
            'state_txt'=>$this->state_txt,
            'created_at'=>$this->created_at,
        ];
    }
}
