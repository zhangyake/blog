<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Socialite;

class AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     */
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            $this->errorUnauthorized();
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
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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
            'expires_in' => auth('api')->factory()->getTTL() * 360,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $admin = auth('admin')->user();
        if ($request->username != $admin->username) {
            return response()->json(['message' => '用户名有误!'], 400);
        }
        $oldPwd = $admin->getAuthPassword();
        $isCheck = Hash::check($request->old_password, $oldPwd);
        if ($isCheck) {
            $admin->password = bcrypt($request->new_password);
            $admin->save();

            return $this->json(['message' => 'Successfully reset']);
        } else {
            $this->error('旧密码不对');
        }
    }

    /**
     * 将用户重定向到 GitHub 的授权页面.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * 从 GitHub 获取用户信息.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = User::firstOrCreate(
            ['github_user_id' => $githubUser->id],
            ['username' => $githubUser->name,
             'nickname' => $githubUser->nickname,
             'email'=>$githubUser->email,
             'avatar'=>$githubUser->avatar]
        );
        $token = auth('api')->login($user);
        return view('login',['token'=>$token,'domain'=>'http://192.168.8.240:8001']);


    }
}
