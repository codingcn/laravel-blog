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
            <div class="sign-up">
                <form action="{{ url('/password/reset') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{request('token')}}">
                    <div class="form-group">
                        <label for="user" class="control-label">Email</label>
                        <input class="form-control" name="email" required="" placeholder="请输入注册的邮箱">
                        <span class="text-danger small">{{$errors->first('email')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="user" class="control-label">新密码</label>
                        <input class="form-control" name="password" required="" placeholder="请输入新密码">
                        <span class="text-danger small">{{$errors->first('password')}}</span>
                    </div>
                    @if($errors->first('result'))
                        <div class="alert alert-success">
                            <strong>成功！</strong>{{$errors->first('result')}}
                        </div>
                    @endif
                    <hr>
                    <div class="form-group clearfix">
                        <button type="submit" class="btn btn-sub w-100" >重置
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('app_js')
@endsection

