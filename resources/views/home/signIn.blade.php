@extends('home.layouts.base')
@section('title','登陆_'.getSetting('site_title'))
@section('app_css')
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/sign.css') }}">
@endsection
@section('page')
    <div class="col-12 col-md-12 col-lg-12 main">
        <div class="logo">
            <a href="{{ url('/index') }}">{{getSetting('site_title')}}</a>
        </div>
        <div class="sign">
            <div class="title">
                <a id="sign-in-btn" class="active" href="{{ url('/sign-in') }}">登录</a>
                <b>·</b>
                <a id="sign-up-btn" href="{{ url('/sign-up') }}">注册</a>
            </div>
            <div class="sign-up">
                <form action="{{ url('/sign-in') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user" class="control-label">用户名 或 Email</label>
                        <input class="form-control" name="user" required="" placeholder="用户名 或 Email"
                               autocomplete="off">
                        <span class="text-danger small">{{$errors->first('user')}}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">密码</label><span class="pull-right"><a href="{{url('/password/reset/email/send')}}">忘记密码</a></span>
                        <input class="form-control" name="password" required="" placeholder="密码" type="password"
                               autocomplete="off">
                        <span class="text-danger small">{{$errors->first('password')}}</span>
                        <span class="text-danger small">{{$errors->first('result')}}</span>
                    </div>
                    <div class="form-group clearfix">
                        <div class="checkbox pull-left">
                            <label><input name="is_remember" value="1" checked="" type="checkbox"> 记住登录状态</label>
                        </div>
                        <button type="submit" class="btn btn-sub pull-right" onclick="">登录
                        </button>
                    </div>
                    <hr>
                    <div class="oauth">
                        <a href="{{'/oauth/github/authorize'}}"> <i class="fab fa-github"></i>使用Github账号登录</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('app_js')
@endsection

