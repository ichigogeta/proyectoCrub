@extends('layouts.app')

@section('meta')
    <meta name="description"
          content="{{$page->title}}">
    <meta name="keywords" content="">
    {{--<meta name="author" content="Raúl Caro Pastorino">--}}
@endsection

@include('layouts.contentbuilder_styles_front')

@section('title')
    @parent
    - {{$page->title}}
@endsection

@php
$page = $page->translate('en');
@endphp

{{--
----- Atributos -----
Título: $page->title
Contenido: $page->body
Slug: $page->slug
Url de la Página: $page->url
Url de la Imagen: $page->urlImage
Fecha de creación en Español: $page->fecha
--}}

@section('content')
    {{$page->title}}
    <br/>
    {{$page->slug}}
    <br/>
    {{$page->url}}
    <br/>
    {{$page->fecha}}
    <br/>
    <img src="{{$page->urlImage}}" style="width: 100px;" />
    <br/>

    <div class="box-content-builder">
        {!! $page->body!!}
    </div>
@endsection

@section('css')
    <style>
        .box-content-builder {

        }
    </style>
@endsection
