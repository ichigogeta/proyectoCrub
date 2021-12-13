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
    
        
        <!-- TODOS LOS PASOS SIGUIENTES SE UTILIZAN CAMPOS OCULTOS PARA VERIFICAR INFORMACION Y PASAR INFORMACION PARA PODER BORRAR O EDITAR O EN SU CASO NULA PARA AGREGAR -->
        @if($tipoBoton === "editarUsuario")<!-- Si del boton que pulsamos esta el campo "editarUsuario" se muestra el formulario para poder editar el usuario -->
            <form action='{{route('mostrarListaUsuarios')}}' method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
                <input type="text" class="form-control" name="usuario" placeholder="Usuario" value="{{$usuario}}">
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" aria-describedby="emailHelp" value="{{$email}}">
                <input type="hidden" name="tipoBoton" value="editarUsuario">
                <button type="submit" class="btn btn-success">Guardar</button>
            <form>
        @else<!-- Si del boton que pulsamos esta el campo "agregarUsuario" se muestra el formulario para poder agregar un nuevo usuario -->
            <form action='{{route('mostrarListaUsuarios')}}' method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
                <input type="text" class="form-control" name="usuario" placeholder="Usuario">
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" aria-describedby="emailHelp">
                <input type="hidden" name="tipoBoton" value="agregarUsuario">
                <button type="submit" class="btn btn-success">Guardar</button>
            <form>
        @endif       
    </form>
    <!-- Le indicamos una routa para que vuelva a la vista de la lista de los usuarios -->
    <a href="{{route('mostrarListaUsuarios')}}" class="btn btn-primary">Volver al listado</a>
</div>
@endsection