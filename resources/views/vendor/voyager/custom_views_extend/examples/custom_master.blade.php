@extends('vendor.voyager.custom_views_extend.custom_master')

{{--
    Secciones:
        page_title → Título de la página.
        icon → Icono junto al título de la página.
        title → Título de la página.
        buttons_custom_top → Botones en la parte superior de la página.
        sections → Bloque con todas las secciones.
        content_custom_top → Bloque de contenido personalizado superior.
        content_custom_bottom → Bloque de contenido personalizado inferior.
--}}

@section('page_title', 'Título de página para pestaña')
@section('title', 'Título superior para la página')
@section('icon', 'fa fa-file-invoice')


{{-- Sección para añadir botones en la parte superior --}}
@section('buttons_custom_top')

@endsection

{{-- Bloque de contenido personalizado superior--}}
@section('content_custom_top')

@endsection

{{-- Bloque con todas las secciones --}}
@section('sections')
    <div class="panel-heading" style="border-bottom:0;">
        <h3 class="panel-title">
            Título del contenido
        </h3>
    </div>

    <div class="panel-body" style="padding-top:0;">
        Contenido
    </div>
@endsection

{{-- Bloque de contenido personalizado inferior --}}
@section('content_custom_bottom')
    <div class="row" style="margin-top: 30px">
        <div class="col-md-12">

        </div>
    </div>
@endsection

@section('css')

@endsection

@section('javascript')

@endsection
