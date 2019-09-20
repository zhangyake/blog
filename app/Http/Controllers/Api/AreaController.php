<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Area\AreaResource;
use App\Models\Area;

class AreaController extends ApiController
{
    public function children($id)
    {
        $areas = Area::with('children.children')->where('parent_id', $id)->orderBy('id', 'asc')->get();

        return AreaResource::collection($areas);
    }
}
