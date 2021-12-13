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
<!-- Seccion para el contenido que vayamos a desarrollar. Digamos que es el cuerpo de la web. -->
@section('content')
    <div class="container">
        <div class="botonAgregar">
            <!-- Le agregamos una ruta para que redirija a esa vista (Las rutas son para redireccionar.--> 
            <form action="{{route('mostrarFormulario')}}" method="GET"><!-- En este caso usamos el boton para agregar un usuario, al ser validado el formulario metemos en campos ocultos de forma null -->
                <!-- @csrf -->
                <input type="submit" class="btn btn-success" value="Agregar usuario">
                <input type="hidden" name="tipoBoton" value="agregarUsuario">
                <input type="hidden" name="id" value="null">
                <input type="hidden" name="usuario" value="null">
                <input type="hidden" name="email" value="null@null.null">
            </form>
        </div>
        <div class="listasUsuarios">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                    <!-- Creamos un foreach y le pasamos la variable que sacamos del compact a esta vista "baseDatos" y la usamos como item -->
                    @foreach ($baseDatos as $item)
                        <tr>
                            <th scope="row">{{$item->id}}</th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td><form action="{{route('mostrarFormulario')}}" method="GET"><!-- Boton para editar un usuario. Por eso primero hay que mandar la informacion a editar con campos ocultos -->
                                <!-- @csrf -->  
                                <input type="submit" class="btn btn-warning" value="Editar usuario">
                                <input type="hidden" name="id" value="{{$item->id}}">
                                <input type="hidden" name="usuario" value="{{$item->name}}">
                                <input type="hidden" name="email" value="{{$item->email}}">
                                <input type="hidden" name="tipoBoton" value="editarUsuario">
                            </form></td>
                            <td><form action="{{route('confirmacion')}}" method="POST"><!-- Boton para enviar a la pagina de confirmacion para eliminar, ya que se va a eliminar un usuario -->
                                    @csrf    
                                    <input type="submit" class="btn btn-danger" value="Eliminar usuario">
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <input type="hidden" name="usuario" value="{{$item->name}}">
                                    <input type="hidden" name="email" value="{{$item->email}}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
@endsection