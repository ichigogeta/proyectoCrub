<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.head')

<body id="app-layout">

@yield('special_content')
@include('layouts.navbar')
@include('layouts.errors')
@include('flash.normal')

<div id="container" class="container">
    @yield('content')
    {{-- @include('layouts.cookie_law')  --}}
</div>

@include('layouts.footer')
</body>
</html>
