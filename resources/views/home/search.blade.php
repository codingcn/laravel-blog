@extends('home.layouts.app')
@section('app-css')
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/filter.css') }}">
@endsection

@section('title', getSetting('site_title'))
@section('main')
    @include('home.shared.article.list')
@endsection
@section('aside')
    @include('home.shared.aside.ad_top')
    @include('home.shared.aside.tags')
    @include('home.shared.aside.recommend')
    @include('home.shared.aside.archives')
    @include('home.shared.aside.articleMap')
    @include('home.shared.aside.ad_bottom')
@endsection
