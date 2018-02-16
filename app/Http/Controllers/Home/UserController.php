<?php

namespace App\Http\Controllers\Home;

use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class UserController extends CommonController
{

    public function signInStore(Request $request)
    {
        //验证
        $this->validate($request, [
            'user' => 'required',
            'password' => 'required',
            'is_remember' => 'integer'
        ]);
        //逻辑
        $user = $request->get('user');
        $is_remember = boolval($request->get('is_remember'));
        if (User::where('phone', $user)->first()) {
            $data['phone'] = $request->get('user');
        } elseif (User::where('email', $user)->first()) {
            $data['email'] = $request->get('user');
        }
        $data['password'] = $request->get('password');
        if (\Auth::attempt($data, $is_remember)) {
            return Redirect::guest('/');
        }
        return \Redirect::back()->withErrors('账号或密码错误！');

    }

    public function signUpStore(Request $request)
    {
        $data = [
            'username' => $request->get('username'),
            'password' => bcrypt($request->get('password')),
        ];
        if ($request->get('sign_up_type') === 'email') {
            //dd($request->all());
            $this->validate($request, [
                'username' => 'required|min:3|unique:users,username',
                'email' => 'required|unique:users,email|email',
                'password' => 'required|min:6|max:32',
            ]);
            $data['email'] = $request->get('email');
            \Mail::to($data['email'])->send(new Welcome(new User()));
        } elseif ($request->get('sign_up_type') === 'phone') {
            //dd($request->all());
            $this->validate($request, [
                'username' => 'required|min:3|unique:users,username',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:6|max:32',
            ]);
            $data['phone'] = $request->get('phone');
        }
        User::create($data);
        return redirect(url('/sign-in'));
    }

    public function signOut()
    {
        \Auth::guard('api')->logout();
        return back();
    }
}
