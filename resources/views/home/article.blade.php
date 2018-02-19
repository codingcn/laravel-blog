@extends('home.layouts.app')
@section('app-css')
    <link rel="stylesheet" href="{{ URL::asset('static/lib/github-markdown/github-markdown.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/article.css') }}">
@endsection

@section('title', $seo['title'])
@section('keywords', $seo['keywords'])
@section('description', $seo['description'])
@section('main')
    @include('home.shared.article.content')
    @include('home.shared.article.comment')
@endsection
@section('aside')
    @include('home.shared.aside.tags')
    @include('home.shared.aside.recommend')
    @include('home.shared.aside.archives')
    @include('home.shared.aside.links')
    @include('home.shared.aside.articleMap')
@endsection

@section('app-js')
    <script src="{{ URL::asset('static/lib/mCustomScrollbar/js/jquery.mCustomScrollbar.min.js') }}"></script>
    <script src="{{ URL::asset('static/lib/mCustomScrollbar/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#article-content").children("h2,h3,h4,h5,h6").each(function (i, item) {
                let tag = $(item).get(0).localName;
                $(item).attr("id", "toc-list-" + i);
                let title = $(item).get(0).innerText
                $(item).append('<a name="' + title + '" class="reference-link"></a>');

                //$("#article-toc-content").append('<li><a class="toc-level-' + tag + '" href="#toc-level-h' + i + '">' + $(this).text() + '</a></li>');
                $("#article-toc-content").append('<li class="toc-level-' + tag + '"><a href="#' + title + '">' + $(this).text() + '</a></li>');
                $(".toc-level-h2").css("padding-left", 0);
                $(".toc-level-h3").css("padding-left", 20);
                $(".toc-level-h4").css("padding-left", 40);
                $(".toc-level-h5").css("padding-left", 60);
                $(".toc-level-h6").css("padding-left", 80);
            });
        });
        $(function () {
            if ($("#article-toc-content").html() == '') {
                $(".article-map").hide();
            } else {
                $(".article-map").show();
            }
            $("#article-toc-content").css("width", $(".aside").width());
            $(window).resize(function () {
                $("#article-toc-content").css("width", $(".aside").width());
            });
            $("#article-toc-content").mCustomScrollbar(
                {
                    theme: "minimal-dark",
                    scrollButtons: {
                        enable: true,
                        scrollType: "continuous",
                        scrollSpeed: 20,
                        scrollAmount: 40
                    },
                    horizontalScroll: false,
                }
            );
        });
        $(window).scroll(function () {
            var toc_top = parseInt($(".article-map").offset().top);
            var scroll_top = $(this).scrollTop();

            if (toc_top - $(".header").height() - 10 <= scroll_top) {
                $(".article-toc-container").css({'position': 'fixed', 'top': $(".header").height() + 10});
            } else {
                $(".article-toc-container").css('position', '');
            }
        });
    </script>
@endsection