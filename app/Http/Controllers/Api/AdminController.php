<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
class AdminController extends ApiController
{

    /**
     * 分页查询
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $admins = Admin::latest()->paginate(10);

        return AdminResource::collection($admins);
    }

    /**
     * 新增记录
     *
     * @param AdminRequest $request
     * @return AdminResource
     */
    public function store(AdminRequest $request)
    {
        $admin = new Admin();
        $admin->fill($request->all());
        $admin->save();

        return new AdminResource($admin);
    }

    /**
     * 查看详情
     *
     * @param $id
     * @return AdminResource
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id);

        return new AdminResource($admin);
    }

    /**
     * 更新
     *
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->fill($request->all());
        $admin->save();

        return $this->noContent();
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Admin::destroy($id);

      return $this->noContent();
    }
}