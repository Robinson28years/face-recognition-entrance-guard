<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;

class AuthController extends Controller
{

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 验证规则，由于业务需求，这里我更改了一下登录的用户名，使用手机号码登录
        $rules = [
            // 'mobile'   => [
            //     'required',
            //     'exists:users',
            // ],
            'email'   => [
                'required',
            ],
            'password' => 'required|string|min:6|max:20',
         ];

        // 验证参数，如果验证失败，则会抛出 ValidationException 的异常
        $params = $this->validate($request, $rules);
        //  dd($params);
       // 使用 Auth 登录用户，如果登录成功，则返回 201 的 code 和 token，如果登录失败则返回
        return ($token = Auth::guard('api')->attempt($params))
            ? response(['token' => 'bearer ' . $token], 201)
            : response(['error' => '账号或密码错误'], 400);
    }

    /**
     * 处理用户登出逻辑
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response(['message' => '退出成功']);
    }
}