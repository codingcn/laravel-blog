@extends('home.layouts.base')
@section('title','注册_'.getSetting('site_title'))
@section('app_css')
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/sign.css') }}">
@endsection
@section('page')
    <div class="col-12 col-md-12 col-lg-12 main">
        <div class="logo">
            <a href="{{ url('/index') }}">边城</a>
        </div>
        <div class="sign">
            <div class="title">
                <a id="sign-in-btn" href="{{ url('/sign-in') }}">登录</a>
                <b>·</b>
                <a id="sign-up-btn" class="active" href="{{ url('/sign-up') }}">注册</a>
            </div>
            <div class="sign-in">
                <form action="{{url('/sign-up')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username" class="control-label">用户名</label>
                        <input type="text" class="form-control" name="username" required="" placeholder="英文字母下划线_组成">
                        <span class="text-danger small">{{$errors->first('username')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="sign-up-mail">
                            <label for="password" class="control-label">电子邮箱</label>
                            <input class="form-control" name="email" placeholder="您的邮箱地址" type="text">
                            <span class="text-danger small">{{$errors->first('email')}}</span>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">密码</label>
                            <input type="text" class="form-control" name="password" required="" placeholder="不少于 6 位">
                            <span class="text-danger small">{{$errors->first('password')}}</span>
                        </div>
                        @if($errors->first('result'))
                        <div class="alert alert-success">
                            {{$errors->first('result')}}
                        </div>
                        @endif
                        <div class="form-group clearfix">
                            <div class="checkbox pull-left">
                                同意并接受<a href="#" target="_blank">《服务条款》</a>
                            </div>
                            <button class="btn btn-sub pull-right">
                                注册
                            </button>
                        </div>
                        <div class="oauth">
                            <a href="{{'/oauth/github/authorize'}}"> <i class="fab fa-github"></i>使用Github账号登录</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection