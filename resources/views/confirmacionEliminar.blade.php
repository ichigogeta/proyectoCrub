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
<div class="container">
    <h1>¿Realmente quiere eliminar este usuario?</h1>
    <form action='{{route('show.form.del')}}' method="POST"><!-- Indicamos al usuario si quiere eliminar o no el usuario escogido. Se usara campos ocultos para poder pasar los datos a borrar -->
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <button type="submit" class="btn btn-warning">Si</button>
    <form>
    <a href="{{route('mostrarListaUsuarios')}}" class="btn btn-primary">No</a>
</div>
@endsection