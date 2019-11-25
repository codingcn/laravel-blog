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


use App\Models\AdminUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;

class AuthController extends CommonController
{
    use  AuthenticatesUsers;

    //调用认证接口获取授权码
    public function token(Request $request, TokenRepository $tokenRepository)
    {

        $data = $request->only(['username', 'password']);
        $admin_user = AdminUser::where([
            ['username', '=', $data['username']]
        ])->first();
        if (is_null($admin_user)) {
            return $this->responseJson('INVALID_TOKEN', [], '账号或密码错误', 401);
        }
        if (\Hash::check($data['password'], $admin_user->password)) {
            $this->_destroyPersonalToken($tokenRepository, $admin_user);
            $token = $admin_user->createToken('admin')->accessToken;
            return $this->responseJson('OK', $token);
        }
        return $this->responseJson('INVALID_TOKEN', [], '账号或密码错误', 401);
    }

    /**
     * 删除个人令牌
     * @param TokenRepository $tokenRepository
     * @param AdminUser $user
     * @throws \Exception
     */
    private function _destroyPersonalToken(TokenRepository $tokenRepository, AdminUser $user)
    {
        //已存在token
        $tokens = $tokenRepository->forUser($user->getKey())->toArray();
        foreach ($tokens ?? [] as $token) {
            //passport官方可能是害怕id会重复吧
            $tokenRepository->findForUser(
                $token['id'], $user->getKey()
            )
                ->delete();
        }
    }
}