<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\UserResource;
use App\User;
use Illuminate\Http\Request;
class UserController extends ApiController
{

    //  用户列表
    public function index()
    {
        $users = User::paginate();
        return UserResource::collection($users);
    }

    //  当前登录用户信息
    public function show(Request $request)
    {
        $user = $request->user();
        return new UserResource($user);
    }

    //  新增用户
    public function store(Request $request)
    {
        $inputs             = $request->all();
        $inputs['password'] = bcrypt(array_get($inputs, 'password'));
        $user               = new User();
        $user->fill($inputs);
        $user->save();
        return new UserResource($user);
    }

    //  修改用户信息
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $user = User::findOrFail($id);
        $user->update($inputs);
        return new UserResource($user);

    }

}
