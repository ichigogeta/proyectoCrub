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
    {{--
    <div class="box-content-builder">
        {!! $page->body!!}
    </div>
    --}}
@endsection
