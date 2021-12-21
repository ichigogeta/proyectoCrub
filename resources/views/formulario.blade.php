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
    <!-- Le indicamos que vaya a la routa guardarDatos dentro del formulario el cual le indicamos con un metodo POST -->
    @if(empty($id))
        <form action=' {{route('store.agregarUsuario')}}' method="POST">
            @csrf
            <input type="text" class="form-control" name="nombre" placeholder="Nombre">
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" aria-describedby="emailHelp">
            <input type="password" class="form-control" name="password" placeholder="password">
            <input type="password" class="form-control" name="otro_nombre" placeholder="Confirmar contraseña" value="">
            <input type="file" accept="image/*" name="archivo">
            <button type="submit" class="btn btn-success">Guardar</button>

        <form>
    @else

        <form action='{{route('store.editarUsuario')}}' method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <input type="password" class="form-control" name="password" placeholder="password" value="">
            <input type="password" class="form-control" name="otro_nombre" placeholder="Confirmar contraseña" value="">
            <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="{{$nombre}}">
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" aria-describedby="emailHelp" value="{{$email}}">
            <!-- Subir Avatar-->
            <button type="submit" class="btn btn-success">Guardar</button>
        <form>
    @endif

    <!-- Le indicamos una routa para que vuelva a la vista de la lista de los usuarios -->
    <a href="{{route('mostrarListaUsuarios')}}" class="btn btn-primary">Volver al listado</a>
</div>
@endsection
