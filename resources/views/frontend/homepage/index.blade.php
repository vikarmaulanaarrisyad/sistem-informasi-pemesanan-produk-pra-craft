@extends('layouts.front')

@section('title', 'Toko Online')

@section('content')

    @include('frontend.homepage._new_product')

    @include('frontend.homepage._wide_banner')

    @include('frontend.homepage._feature_product')

    @include('frontend.homepage._wide_banner_bottom')

    @include('frontend.homepage._latest_blog')

    @include('frontend.homepage._arrival')

@endsection
