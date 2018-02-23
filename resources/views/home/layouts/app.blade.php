<?php
$categories = \App\Models\ArticleCategory::orderBy('serial_number', 'ASC')->get(['id', 'name']);
?>
        <!DOCTYPE html>
<html lang="zh-CN">

<head>
    <!-- Required meta tags -->
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=0,shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="authorization"
          content="{{ \Auth::guard('home_session')->check()?\Auth::guard('home_session')->user()->api_token:'' }}">
    <!-- Bootstrap CSS -->
    @section('app-css')
    @show

    <link rel="stylesheet" href="{{ URL::asset('static/home/css/app.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/loading.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/lib/font-awesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/lib/mCustomScrollbar/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/layout.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/index.css') }}">
    <title>@yield('title')</title>
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?8b621fa6b5c2343a2e74bc9b66ae558e";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body>
<!--进度加载块start-->
<div id="loading" class="loading">
    <div class="icon">
        <i></i>
        <i></i>
        <i></i>
        <i></i>
        <i></i>
    </div>
</div>
<!--进度加载块end-->
<div id="app">
    <div class="header">
        <div class="container">
            <div>
                <div class="logo float-left">
                    <a href="{{url('/')}}">
                        {{--<h1>边城</h1>--}}
                        <img src="{{ !empty(getSetting('site_logo'))?\Storage::url(getSetting('site_logo')):asset('static/home/img/logo.png') }}"
                             alt="边城">
                    </a>
                </div>

                <div class="menu-pc d-none d-xl-block d-lg-block">
                    <ul class="menu-item float-left">
                        <li>
                            <a href="{{ url('/index') }}">主页</a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ url('/categories',$category->id) }}">{{$category->name}}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{url('/about')}}">关于</a>
                        </li>
                    </ul>
                    <ul class="float-right">
                        <li class="search-box">
                            <form action="{{url('/article/search')}}" method="get">
                                <input name="keywords" class="search-input" type="text" placeholder="搜索内容...">
                                <button class="search-btn" type="submit"><i class="fas fa-search"></i>
                                </button>
                            </form>
                        </li>
                        <li class="member-btn">
                            @if(\Auth::guard('home_session')->check())
                                <?php
                                $user = \Auth::guard('home_session')->user();
                                if (!empty($user->avatar)) {
                                    $avatar = $user->avatar;
                                } else {
                                    $avatar = url('/static/home/img/avatar/' . substr($user->id, -1) . '.jpg');
                                }
                                ?>
                                <img src="{{$avatar}}" alt="{{$user->username}}">
                                <a href="{{ url('/') }}">{{\Auth::guard('home_session')->user()->username}}</a>
                                |
                                <a href="{{ url('/sign-out') }}">注销</a>
                            @else

                                <a href="{{ url('/sign-in') }}">登陆</a>
                                /
                                <a href="{{ url('/sign-up') }}">注册</a>

                            @endif
                        </li>
                    </ul>
                </div>
                <div class="menu-bar float-right d-xl-none d-lg-none">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="menu-touch">
                    <div class="menu-close">
                        <i class="fas fa-times"></i>close
                    </div>
                    <ul>
                        <li class="member-btn">
                            <a href="{{ url('/sign-in') }}">登陆</a>
                            <span>/</span>
                            <a href="{{ url('/sign-up') }}">注册</a>
                        </li>
                        <li class="search-box">
                            <form action="{{url('/article/search')}}">
                                <input name="keywords" class="search-input" type="text" placeholder="搜索内容...">
                                <button class="search-btn" type="submit"><i class="fas fa-search"></i>
                                </button>
                            </form>
                        </li>
                        <li>
                            <a href="{{ url('/index') }}">主页</a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ url('/categories',$category->id) }}">{{$category->name}}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{url('/about')}}" target="_blank">关于</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container wrap">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 main">
                @section('main')
                @show
            </div>
            <div class="aside col-12 col-md-12 col-xl-4 col-lg-4 d-none d-xl-block d-lg-block">
                @section('aside')
                @show
            </div>
        </div>
    </div>
    <div class="footer">
        <p> ©2015-2018
            <a href="https://ashub.cn" target="_blank">AsHub</a> All Rights Reserved. Powered by Alan
        </p>
        <p>
            <a href="http://www.miitbeian.gov.cn/" target="_blank"><?=getSetting('site_icp')?></a>
        </p>
    </div>
</div>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="{{ URL::asset('static/home/js/app.js') }}"></script>
<script src="{{ asset('static/lib/svg3dtagcloud/jquery.svg3dtagcloud.min.js') }}"></script>
<script>
    function init_tags() {
        var tags = '<?=json_encode($tags)?>';
        tags = JSON.parse(tags);
        var word_array = [];
        tags.map(function (v, k) {
            word_array.push({
                label: v.name,
                target: "_blank",
                url: "{{url('/tags')}}/" + v.name
            })
        });
        $('#tag-cloud').svg3DTagCloud(
            {
                //一个对象数组，用于初始化标签。
                entries: word_array,
                //标签云的宽度。
                width: Math.abs($('.aside').width()),
                //标签云的高度。
                height: Math.abs($('.aside').width() * 0.6),
                //标签云的半径。
                radius: '100%',
                //标签云的最小半径。
                radiusMin: '60',
                //是否使用背景色。
                bgDraw: true,
                //背景颜色。
                bgColor: '#fff',
                //鼠标滑过标签时的标签透明度。
                opacityOver: '0.8',
                //鼠标离开标签时的标签透明度。
                opacityOut: '0.2',
                //标签透明度过渡速度。
                opacitySpeed: 1,
                //how the content is presented。
                fov: 800,
                //标签云动画的速度。
                speed: 0.8,
                //标签云的字体。
                fontFamily: 'Oswald, Arial, sans-serif',
                //标签云的字体大小。
                fontSize: '15',
                // 标签云的字体颜色。
                fontColor: '#000',
                // 标签云的字体的fontWeight。
                fontWeight: 'normal',
                // 标签云的字体样式。
                fontStyle: 'normal',
                // 标签云的字体的fontStretch。
                fontStretch: 'normal',
                // 标签云字体是否转大写。
                fontToUpperCase: false
            }
        );
    };
    init_tags();
</script>
<script>
    $(".menu-bar").click(function () {
        $(".menu-touch").animate({'width': '200px'}, 300, function () {

        });
    });
    $(".main,.footer,.menu-close").click(
        function () {
            $(".menu-touch").animate({'width': '0px'}, 300, function () {
            });
        }
    );
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
@section('app-js')
@show

</body>
<script>
    document.onreadystatechange = function () {
        if (document.readyState === "complete") {
            document.body.removeChild(document.getElementById("loading"));
        }
    }
</script>
</html>