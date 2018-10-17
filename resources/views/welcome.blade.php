@extends('layouts.app')

@section('meta')
    <meta name="description"
          content="Página de inicio">
    <meta name="keywords" content="xerintel,projecto,web">
    {{-- <meta name="author" content="Javier García"> --}}
@endsection

@section('title')
    @parent
    - Inicio
@endsection

@section('content')
    <div id="homepage">
        <!-- Esto es un comentario público-->
        {{-- Esto es un comentario privado --}}
        <h1>Si puedes leer esto, es que se instaló bien.</h1>
        <p>Barra de cookies ocultada, ver más en views/layouts/app.blade.php</p>
        <h2>Enlaces pre-generados</h2>
        <a href="{{url('/pagina/sobre-nosotros')}}">Sobre nosotros</a> <br>
        <a href="{{url('/pagina/politica-de-privacidad')}}">Política de Privacidad</a> <br>
        <a href="{{url('/pagina/aviso-legal-y-cookies')}}">Aviso Legal</a>

        <h2>¿Quieres ir a la intranet?</h2>
        <a href="{{url('/intranet')}}"> {{url('/intranet')}}</a>
        <h3>¿Fallan los enlaces o las fotos?</h3>
        <p>
            Revisa la URL que pusiste en el fichero <strong>.env</strong>
        </p>

    </div>
@endsection