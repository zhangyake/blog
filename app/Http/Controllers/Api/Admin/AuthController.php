<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function __construct()
    {
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $tmpCode = Redis::get(request('uuid')); // 获取redis
        $code = request('code');
        if (!$tmpCode) {
            return response()->json(['message' => '验证码已过期！'], 400);
        }
        if (0 !== strcasecmp($code, $tmpCode)) {
            return response()->json(['message' => '验证码有误！'], 400);
        }
        $credentials = request(['name', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => '账号或密码有误！'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()
                        ->factory()
                        ->getTTL() * 60,
            ]);
    }

    public function resetPassword(Request $request)
    {
        $this->reqValidate($request, [
                'username' => 'required',
                'old_password' => 'required',
                'new_password' => 'required',
            ]);
        $admin = auth()->user();
        if ($request->username != $admin->name) {
            return response()->json(['message' => '用户名有误!'], 400);
        }
        $oldPwd = $admin->getAuthPassword();
        $isCheck = Hash::check($request->old_password, $oldPwd);
        if ($isCheck) {
            $admin->password = bcrypt($request->new_password);
            $admin->save();

            return response()->json(['message' => 'Successfully reset']);
        } else {
            return response()->json(['message' => '旧密码不对'], 400);
        }
    }
}
