<?php
/**
 * File: Auth.php
 * Description: 无
 * User: Alan
 * Datetime: 2017/9/24 10:10
 * Copyright Copyright(c) 2017
 * Version 1.0
 */

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController
{
    use  AuthenticatesUsers;

    //调用认证接口获取授权码
    public function token(Request $request)
    {
        $credentials = $request->only(['username', 'password', 'grant_type']);
        //这儿做一下账号密码过滤操作
        $request->request->add([
            'username' => $credentials['username'],
            'phone' => $credentials['username'],
            'email' => $credentials['username'],
            'password' => $credentials['pass
            
            word'],
            'grant_type' => $credentials['grant_type'],
            'client_id' => config('passport.client_id'),
            'client_secret' => config('passport.client_secret'),
            'scope' => config('passport.scope'),
        ]);
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $response = \Route::dispatch($proxy);
        return $response;
    }

    public function refreshToken(Request $request)
    {
        $credentials = $request->only(['refresh_token', 'scope']);
        //这儿做一下账号密码过滤操作

        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $credentials['refresh_token'],
            'scope' => $credentials['scope'],
            'client_id' => config('passport.client_id'),
            'client_secret' => config('passport.client_secret'),
        ]);
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $response = \Route::dispatch($proxy);
        return $response;
    }

    public function adminUser()
    {
        $user = \Auth::guard('api')->user();
        return \GuzzleHttp\json_encode($user);
    }

}