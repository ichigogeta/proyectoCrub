<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

@include('mail.layouts.consts')

<head>
    @include('mail.layouts.head')
    @include('mail.layouts.styles')
</head>

<body>
    <div id="box-mail">
        {{-- Cabecera, título, logotipo --}}
        <div id="box-header">
            @include('mail.layouts.preheader')
            @yield('header')
        </div>

        {{-- Contenido principal --}}
        <div id="box-content">
            {{-- Antes del contenido principal --}}
            @yield('before-content')

            {{-- Contenido --}}
            @yield('content')

            {{-- Después del contenido principal --}}
            @yield('after-content')
        </div>

        {{-- Footer --}}
        <div id="box-footer">
            @include('mail.layouts.footer')
        </div>
    </div>

    {{-- CSS personalizado para una zona concreta --}}
    @yield('css')
</body>
</html>

