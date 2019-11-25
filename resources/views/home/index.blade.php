@extends('home.layouts.app')
@section('title', $seo['title'])
@section('keywords', $seo['keywords'])
@section('description', $seo['description'])
@section('main')
    @include('home.shared.article.list')
@endsection
@section('aside')
    @include('home.shared.aside.tags')
    @include('home.shared.aside.recommend')
    @include('home.shared.aside.archives')
    @include('home.shared.aside.links')
@endsection
