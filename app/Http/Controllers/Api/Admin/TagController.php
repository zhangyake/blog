<?php

namespace App\Http\Controllers\Api\Admin;


use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\TagResource;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class TagController extends ApiController
{


    //  标签列表
    public function index()
    {
        $tags = Tag::orderBy('id')->get();
        return TagResource::collection($tags);
    }

    public function store(Request $request){
        $inputs = $request->only(['name']);
        $this->reqValidate($request,[
            'name'=>'required|unique:tags,name'
        ]);
        $tag = new Tag();
        $tag->fill($inputs);
        $tag->save();
        return new TagResource($tag);
    }

    public function update(Request $request,$id){
        $inputs = $request->merge(compact('id'));
        $this->reqValidate($request,[
            'id' =>'required|exists:tags,id',
            'name'=>['required',Rule::unique('tags')->ignore($id)]
        ]);
        $tag = Tag::findOrFail($id);
        $tag->update(['name'=>$inputs['name']]);
        return new TagResource($tag);
    }



}
