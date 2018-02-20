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
            <h4 class="title">
                <div class="">
                    <a class="" href="{{ url('/sign-in') }}">登录</a>
                    <b>·</b>
                    <a id="sign-up-btn" class="active" href="{{ url('/sign-up') }}">注册</a>
                </div>
            </h4>
            <div class="sign-in">
                <form action="{{url('/sign-up')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username" class="control-label">用户名</label>
                        <input type="text" class="form-control" name="username" required="" placeholder="英文字母下划线_组成"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <div class="chose_sign_up_type">
                            <label class="radio-inline">
                                <input name="sign_up_type" value="email" type="radio" checked> 用 Email 注册
                            </label>
                            <label class="radio-inline">
                                <input name="sign_up_type" value="phone" type="radio"> 用手机号注册
                            </label>
                        </div>

                        <div class="sign-up-mail">
                            <input class="form-control" name="email" placeholder="您的邮箱地址"
                                   autocomplete="off" type="text">
                        </div>
                        <div class="sign-up-phone" style="display: none">
                            <div class="input-group phone-input">
                                <input class="form-control" name="phone" placeholder="仅支持大陆手机号" type="text"
                                       autocomplete="off">
                            </div>
                            <div class="input-group">
                                <input type="text"
                                       name="vcode"
                                       class="form-control"
                                       placeholder="验证码" autocomplete="off">
                                <span class="input-group-btn">
                                    <button id="vcode" class="send-validate-code btn btn-default"
                                            type="submit">获取验证码</button></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">密码</label>
                            <input type="text" class="form-control" name="password" required="" placeholder="不少于 6 位"
                                   autocomplete="off">
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
@section('app_js')
    <script>
        $(function () {
            if ($("input[name=sign_up_type]:checked").val() == 'phone') {
                $(".sign-up-mail").hide();
                $(".sign-up-phone").show();
            }
            if ($("input[name=sign_up_type]:checked").val() == 'email') {
                $(".sign-up-phone").hide();
                $(".sign-up-mail").show();
            }
            $("input[name=sign_up_type]").change(function () {
                if ($(this).val() == 'phone') {
                    $(".sign-up-mail").hide();
                    $(".sign-up-phone").show();
                }
                if ($(this).val() == 'email') {
                    $(".sign-up-phone").hide();
                    $(".sign-up-mail").show();
                }
            });
        });

        var enable = true;
        $("#vcode").click(function () {
            if (enable == false) {
                return;
            }
            enable = false;
            num = 60;
            var interval = window.setInterval(function () {
                $("#vcode").html(--num + "s重新发送");
                $("#vcode").removeClass("send-validate-code");
                $("#vcode").addClass("click-send-validate-code");
                if (num == 0) {
                    enable = true;
                    window.clearInterval(interval);
                    $("#vcode").html("重新发送");
                    $("#vcode").addClass("send-validate-code");
                    $("#vcode").removeClass("click-send-validate-code");

                }
            }, 1000);
            var phone = $("input[name=phone]").val();
            $.ajax({
                url: "{{ url('/service/sendsms') }}",
                data: {
                    phone: phone,
                },
                dataType: 'json',
                type: 'POST',
                cache: false,
                success: function (data) {
                    if (data == null) {

                    }
                }
            });
        });


    </script>
@endsection
