<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

{{-- Assets y metaetiquetas de cabecera --}}
@include('layouts.head')

<body id="app-layout">

{{-- Barra de navegación --}}
@include('layouts.navbar')

{{-- Slides --}}
{{-- @include('layouts._slides') --}}

{{-- Mensajes flash --}}
@include('flash.todos')

{{-- Contenido de la página --}}
@yield('content')
{{-- @include('layouts.cookie_law')  --}}


{{-- Footer --}}
@include('layouts.footer')

{{-- Assets después del footer --}}
@include('layouts.footer_meta')
@yield('late_footer')

{{-- Secciones para añadir assets al final desde una página que extienda --}}
@yield('css')
@yield('styles')
@yield('style')
@yield('javascript')
@yield('js')
</body>
</html>
