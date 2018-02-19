@extends('home.layouts.base')
@section('title','登陆_'.getSetting('site_title'))
@section('app_css')
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/sign.css') }}">
@endsection
@section('page')
    <div class="col-12 col-md-12 col-lg-12 main">
        <div class="logo">
            <a href="{{ url('/index') }}">边城</a>
        </div>
        <div class="sign">
            <h4 class="title">
                <div class="normal-title">
                    <a id="sign-in-btn" class="active" href="{{ url('/sign-in') }}">登录</a>
                    <b>·</b>
                    <a id="sign-up-btn" href="{{ url('/sign-up') }}">注册</a>
                </div>
            </h4>
            <div class="sign-up">
                <form action="{{ url('/sign-in') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user" class="control-label">手机号 或 Email</label>
                        <input class="form-control" name="user" required="" placeholder="11 位手机号 或 Email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">密码</label><span class="pull-right"><a href="/user/forgot">忘记密码</a></span>
                        <input class="form-control" name="password" required="" placeholder="密码" type="password" autocomplete="off">
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group clearfix">
                        <div class="checkbox pull-left">
                            <label><input name="is_remember" value="1" checked="" type="checkbox"> 记住登录状态</label>
                        </div>
                        <button type="submit" class="btn btn-sub pull-right" onclick="">登录
                        </button>
                    </div>
                    <hr>
                    <div>
                        <a href="{{'/oauth/github/authorize'}}"> 使用Github登录</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('app_js')
    <script>
        $(function () {
            if ($("input[name=sign_on_type]:checked").val() == 'phone') {
                $(".sign-on-mail").hide();
                $(".sign-on-phone").show();
            }
            if ($("input[name=sign_on_type]:checked").val() == 'mail') {
                $(".sign-on-phone").hide();
                $(".sign-on-mail").show();
            }
            $("input[name=sign_on_type]").change(function () {
                if ($(this).val() == 'phone') {
                    $(".sign-on-mail").hide();
                    $(".sign-on-phone").show();
                }
                if ($(this).val() == 'mail') {
                    $(".sign-on-phone").hide();
                    $(".sign-on-mail").show();
                }
            });
        })


    </script>
@endsection

