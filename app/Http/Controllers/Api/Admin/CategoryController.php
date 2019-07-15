<?php

namespace App\Http\Controllers\Api\Admin;
use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CategoryController extends ApiController
{

    public function index()
    {
        $categories = Category::orderBy('id')
                              ->get();
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $inputs = $request->only(['name']);
        $this->reqValidate($request, [
            'name' => 'required|unique:categories,name'
        ]);
        $category = new Category();
        $category->fill($inputs);
        $category->save();
        return new CategoryResource($category);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->merge(compact('id'));
        $this->reqValidate($request, [
            'id'   => 'required|exists:categories,id',
            'name' => ['required',
                Rule::unique('categories')
                    ->ignore($id)
            ]
        ]);
        $category = Category::findOrFail($id);
        $category->update(['name' => $inputs['name']]);
        return new CategoryResource($category);
    }

}
