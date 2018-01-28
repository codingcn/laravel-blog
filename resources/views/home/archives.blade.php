@extends('home.layouts.app')
@section('app-css')
    <link rel="stylesheet" href="{{ URL::asset('static/home/css/filter.css') }}">
@endsection
@section('title', $seo['title'])
@section('keywords', $seo['keywords'])
@section('main')
    @include('home.shared.filter.archives')
@endsection
@section('aside')
    @include('home.shared.aside.tags')
    @include('home.shared.aside.recommend')
    @include('home.shared.aside.archives')
    @include('home.shared.aside.articleMap')
@endsection