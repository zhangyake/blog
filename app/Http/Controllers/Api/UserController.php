<?php

namespace App\Http\Controllers\Api;


use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


//  用户列表
    public function index()
    {
        $data = $this->userRepository->page()->toArray();
        $users['total'] = array_get($data,'total');
        $users['current_page'] = array_get($data,'current_page');
        $users['last_page'] = array_get($data,'last_page');
        $users['list'] = array_get($data,'data');
        return $this->successReturn(compact('users'));
    }

//  当前登录用户信息
    public function show(Request $request)
    {
        $user = $request->user();
        return $this->successReturn(compact('user'));
    }

//  新增用户
    public function store(Request $request)
    {
        $inputs = $request->all();
        $inputs['password'] = bcrypt(array_get($inputs,'password','123456'));
        $inputs['date'] = date('Y-m-d',strtotime(array_get($inputs,'date'))) ;
        $user   = $this->userRepository->store($inputs);
        return $this->successReturn(compact('user'));
    }


//  修改用户信息
    public function update(Request $request, $id)
    {
        $inputs = $request->all();

        $user = $this->userRepository->getById($id);

        if ($user) {

            $result = $this->userRepository->update($id, $inputs);

            if ($result) {
                return $this->successReturn();
            }

        } else {
            return $this->errorReturn('参数有误', 400);
        }
        return $this->errorReturn('', 500);
    }

}
