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
                <form action="{{ url('/password/reset/email/send') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user" class="control-label">Email</label>
                        <input class="form-control" name="email" required="" placeholder="请输入注册的邮箱">
                        <span class="text-danger small">{{$errors->first('email')}}</span>
                    </div>
                    @if($errors->first('result'))
                        <div class="alert alert-success">
                            {{$errors->first('result')}}
                        </div>
                    @endif
                    <hr>
                    <div class="form-group clearfix">
                        <button type="submit" class="btn btn-sub w-100" >发送密码重置邮件
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('app_js')
@endsection