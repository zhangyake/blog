<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleArchiveCollection extends ResourceCollection
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
            'data' => $this->collection->groupBy(function ($item, $key) {
                return substr($item['created_at'], 0,4);
            }),
        ];
    }
}
