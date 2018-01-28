@extends('home.layouts.app')
@section('app-css')
    <style>
        .about h2{
            margin:1.8rem auto;
            font-weight: bold;
        }
        .about h3 {
            font-weight: bold;
        }

        .contact-way {
            margin-bottom: 5rem;
        }
    </style>
@endsection
@section('title', "关于_".getSetting('site_title'))
@section('keywords','关于')
@section('main')
    @include('home.shared.main.about')
@endsection
@section('aside')
    @include('home.shared.aside.tags')
    @include('home.shared.aside.recommend')
    @include('home.shared.aside.archives')
    @include('home.shared.aside.links')
@endsection


