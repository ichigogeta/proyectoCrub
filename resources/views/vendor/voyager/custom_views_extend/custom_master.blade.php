@extends('voyager::master')
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

@section('page_header')
    <h1 class="page-title">
        <i class="@yield('icon', 'fa fa-user')"></i>
        @yield('title', 'Título de la página (title)')&nbsp;

        {{-- Sección para añadir botones en la parte superior --}}
        <div style="display: inline-block; margin-right: 18px;">
            @yield('buttons_custom_top')
        </div>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    {{-- Bloque de contenido personalizado superior--}}
                    <div class="panel-body" style="padding-top:5px; border-bottom:0;">
                        @yield('content_custom_top')
                    </div>

                    {{-- Bloque con todas las secciones --}}
                    @yield('sections')

                    {{-- Bloque de contenido personalizado inferior --}}
                    <div class="panel-body" style="padding-top:5px; border-bottom:0;">
                        @yield('content_custom_bottom')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
