<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>控制面板</title>
    <!-- Styles -->
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        html, body, #app, .wrapper {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        body {
            font-family: "Helvetica Neue", Helvetica, "microsoft yahei", arial, STHeiTi, sans-serif;
        }
    </style>
    <link rel="stylesheet" href="{{ URL::asset('static/lib/font-awesome/css/font-awesome.css') }}">
</head>
<body>
<div id='app'>
    <router-view></router-view>
</div>
<script type="text/javascript" src="{{ URL::asset('static/admin/js/app.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
</html>
