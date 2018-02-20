<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=0,shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('static/lib/font-awesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/app.css') }}">
    @section('app_css')
    @show
    <title>@yield('title')</title>
</head>

<body>
<div id="app">
    <div class="container wrap">
        <div class="row">
            @section('page')
            @show
        </div>
    </div>
</div>


<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="{{ URL::asset('static/home/js/app.js') }}"></script>
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
  )
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

@section('app_js')
@show
</body>

</html>