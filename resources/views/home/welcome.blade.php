<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=0,shrink-to-fit=no">
    <title>生活家-面朝大海，春暖花开</title>
    <link rel="shortcut icon" href="{{ URL::asset('/favicon.ico') }}" />
    <link rel="bookmark" href="{{ URL::asset('/favicon.ico') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ URL::asset('static/lib/font-awesome/css/font-awesome.css') }}">
    <style type="text/css">
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font: 400 16px/1.7 "Microsoft JhengHei", sans-serif;
            color: #444;
            min-width: 320px;

            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .welcome {
            text-align: center;
            height: 568px;
            padding: 0 20px;
            margin: 0 auto;
            position: relative;
            /*脱离文档流*/
            top: 50%;
            /*偏移*/
            transform: translateY(-50%);
        }

        .welcome .nickname {
            height: 46px;
            line-height: 46px;
            font-size: 26px;
            font-weight: bold;
        }

        .welcome .avatar img {
            padding: 4px;
            border: 1px solid #eaeaea;
            display: inline-block;
            width: 110px;
            height: 110px;
            margin: 70px auto 0;
            border-radius: 50%;
        }

        .welcome .address {
            height: 36px;
            line-height: 36px;
            font-size: 12px;
        }

        .welcome .about {
            margin: 5px auto;
        }

        .welcome .link a {
            color: #37474f;
            display: inline-block;
            margin: auto 8px;
            height: 36px;
            line-height: 36px;
        }

        .welcome .link a:hover {
            color: #000000;
        }
    </style>

</head>

<body>
<div class="welcome">
    <div class="avatar">
        <img src="{{ URL::asset('static/home/img/avatar.jpg') }}">
    </div>
    <div class="nickname">
        Alan
    </div>
    <div class="address">
        <i class="fa fa-map-marker" aria-hidden="true"></i> Yunnan,Kunming,China
    </div>
    <div class="about">
        The more you have learned,the more senseless you will feel.
    </div>

    <div class="link">
        <a href="{{ url('/index') }}">Blog</a>
        <a href="{{ url('/about') }}" target="_blank">About</a>
        <a href="{{ url('/guestbook') }}" target="_blank">Guestbook</a>
        <a href="{{ url('/link') }}" target="_blank">Links</a>
        <a href="https://github.com/codingcn" target="_blank">Gayhub</a>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('static/lib/ribbon/ribbon.min.js') }}"></script>
</body>

</html>