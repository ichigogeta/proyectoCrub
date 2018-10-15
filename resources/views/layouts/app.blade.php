<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body id="app-layout">

@include('layouts.navbar')
@include('layouts.errors')
@include('flash.normal')

<div id="container" class="container">
    @yield('content')
    {{-- @include('layouts.cookie_law')  --}}
</div>

@include('layouts.footer')
@yield('late_footer')
</body>
</html>
