<?php

namespace App\Http\Controllers\Home;

use App\Mail\EmailVerification;
use App\Mail\PasswordReset;
use App\Models\EmailVerify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class UserController extends CommonController
{

    /**
     * 登录
     * @param Request $request
     * @return mixed
     */
    public function signInStore(Request $request)
    {
        //验证
        $this->validate($request, [
            'user' => 'required',
            'password' => 'required',
            'is_remember' => 'integer'
        ]);
        //逻辑
        $user = $request->input('user');
        $is_remember = boolval($request->input('is_remember'));
        if (User::where('username', $user)->first()) {
            $data['username'] = $request->input('user');
        } elseif (User::where('email', $user)->first()) {
            $data['email'] = $request->input('user');
        }
        $data['password'] = $request->input('password');
        if (\Auth::guard('home_session')->attempt($data, $is_remember)) {
            return Redirect::guest('/');
        }
        return back()->withInput()->withErrors(['result' => '账号或密码错误']);
    }

    /**
     * 保存注册信息
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signUpStore(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:3|unique:users,username',
            'email' => 'required|email',
            'password' => 'required|min:6|max:32',
        ]);
        $data = $request->only([
            'username',
            'email',
            'password',
        ]);
        $data['api_token'] = str_random(64);
        $data['email_verify_status'] = 1;
        $email_verify = EmailVerify::updateOrCreate(
            [
                'email' => $data['email']
            ],
            [
                'email' => $data['email'],
                'token' => str_random(64),
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        $user = User::where('email', $data['email'])->first();
        if (is_null($user)) {
            User::create($data);
        } else {
            if ($user->email_verify_status === 2) {
                return back()->withInput()->withErrors(['email' => '该邮箱已注册']);
            } else {
                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->email_verify_status = $data['email_verify_status'];
                $user->save();
            }
        }
        $this->sendVerifyEmailTo($email_verify);
        return back()->withInput()->withErrors(['result' => '注册成功，请注意查收激活邮件！']);
    }

    /**
     * 发送验证邮件
     * @param EmailVerify $email_verify
     */
    public function sendVerifyEmailTo(EmailVerify $email_verify)
    {
        \Mail::to($email_verify->email)->send(new EmailVerification($email_verify));
    }

    /**
     * 邮箱验证
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function emailVerify($token)
    {

        $email_verify = EmailVerify::where('token', $token)->first();
        if (is_null($email_verify)) {
            return \redirect('/');
        } else {
            try {
                \DB::beginTransaction();
                $user = User::where('email', (array)$email_verify->email)->first();
                $user->email_verify_status = 2;
                $user->save();
                $email_verify->delete();
                \Auth::guard('home_session')->loginUsingId($user->id);
                \DB::commit();
            } catch (\Exception $e) {
                \Log::info('EmailVerify error ', (array)$e);
                \DB::rollBack();
            }
            return \redirect('/');
        }
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (is_null($user)) {
            return back()->withInput()->withErrors(['result' => '该邮箱未注册，请直接注册。']);
        }
        $reset_email = \App\Models\PasswordReset::updateOrCreate(
            [
                'email' => $request->input('email')
            ],
            [
                'email' => $request->input('email'),
                'token' => str_random(64),
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
        \Mail::to($reset_email->email)->send(new PasswordReset($reset_email));
        return back()->withInput()->withErrors(['result' => '重置密码申请邮件已发送，请及时查看。']);
    }

    public function passwordReset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|max:32',
        ]);
        $data = $request->only([
            'email',
            'token',
            'password',
        ]);
        $password_reset = \App\Models\PasswordReset::where([
            ['token', '=', $data['token']],
            ['email', '=', $data['email']],
        ])->first();
        if (is_null($password_reset)) {
            return back()->withInput()->withErrors(['result' => '密码重置失败，请重试。']);
        } else {
            try {
                \DB::beginTransaction();
                $user = User::where('email', $password_reset->email)->first();
                $user->password = bcrypt($data['password']);
                $user->save();
                $password_reset->delete();
                \Auth::guard('home_session')->loginUsingId($user->id);
                \DB::commit();
            } catch (\Exception $e) {
                \Log::info('PasswordReset error ', (array)$e);
                \DB::rollBack();
            }
            return \redirect('/');
        }
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signOut()
    {
        \Auth::guard('home_session')->logout();
        return back();
    }
}
