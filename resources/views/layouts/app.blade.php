<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body id="app-layout">

@include('layouts.navbar')
@include('flash.errors')
@include('flash.normal')


    @yield('content')
    {{-- @include('layouts.cookie_law')  --}}


@include('layouts.footer')
@yield('late_footer')
</body>
</html>
