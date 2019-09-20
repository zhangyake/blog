<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Requests\AdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * 分页查询.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $admins = User::latest()->paginate(10);

        return AdminResource::collection($admins);
    }

    /**
     * 新增记录.
     *
     * @param Request $request
     *
     * @return AdminResource
     */
    public function store(Request $request)
    {
        $admin = new User();
        $admin->fill($request->all());
        $admin->save();

        return new AdminResource($admin);
    }

    /**
     * 查看详情.
     *
     * @param $id
     *
     * @return AdminResource
     */
    public function show($id)
    {
        $admin = User::findOrFail($id);

        return new AdminResource($admin);
    }

    /**
     * 更新.
     *
     * @param AdminRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = User::findOrFail($id);
        $admin->fill($request->all());
        $admin->save();

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
        User::destroy($id);

        return $this->noContent();
    }
}
