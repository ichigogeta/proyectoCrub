@extends('layouts.app')<!-- Layout que viene de la bienvenida y ya esta creado en la carpeta "resource/layout/app". Indicamos la ruta de carpetas separadas por puntos. -->

<!-- ATENCION AQUI PORQUE TODO ESTA SEPARADO. CADA SECCION TIENE UN YIELD Y ESTA EN UN ARCHIVO DIFERENTE EL CUAL HA DESARROLLADO UNA PLANTILLA WEB Y SOLO USAMOS EL CUERPO DE ABAJO "content") -->
<!-- TODO EL CUERPO ESTA DESARROLLADO CON BOOSTRAP, hay que verse las clases y como se usarian a la hora del diseño -->
<!-- Seccion llamada meta que despues se mostrara en un campo llamado "yield()"-->
@section('meta')
    <meta name="description"
          content="">
    <meta name="keywords" content="">
    {{--<meta name="author" content="Javier García">--}}
@endsection
<!-- Seccion para el titulo de la web que ya esta predefinido -->
@section('title')
    @parent
    - Plantilla vacía
@endsection
<!-- Seccion para el contenido que vayamos a desarrollar. Digamos que es el cuerpo de la web.-->
@section('content')
    <h1>Validación Formacion por JS</h1>
    <br>
    <form action="{{route('mensajeValido')}}" method="GET" id="validarFormulario">
        <input type="text" name="usuario" id="user" placeholder="Usuario">
        <input type="password" name="password" id="pass" placeholder="Contraseña">
        <br>
        <br>
        <input type="submit" name="botonEnviar" class="btn btn-primary">
    </form>
@endsection