<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')
    <title>
        @section('title')
            {{ config('app.name', 'Laravel') }}
        @show
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/ico" sizes="16x16">

    {{-- Tipografías --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"
          rel='stylesheet'
          type='text/css' />

    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"
          rel='stylesheet'
          type='text/css' />

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{-- Optional theme --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <!-- JavaScripts -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    {{-- NUESTROS ESTILOS Y SCRIPTS --}}
    @yield('late_head')
    <link href="{{url(mix('css/app.css')) }}" rel="stylesheet"> {{-- mix() es lo mismo que asset() pero si usas SASS --}}
    <link href="{{url('css/estilo.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/validacion.js')}}"></script>
</head>
