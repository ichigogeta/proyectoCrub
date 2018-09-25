<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('meta')
    <title>
        @section('title')
            {{ config('app.name', 'Laravel') }}
        @show
    </title>
    @include('layouts.head')
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body id="app-layout">
@yield('special_content')
@include('layouts.navbar')
@include('layouts.errors')
@include('flash.normal')
<div id="container" class="container">
    @yield('content')
    @include('layouts.cookie_law')
</div>
<footer class="footer">
    @include('layouts.footer')
</footer>
</body>
</html>
