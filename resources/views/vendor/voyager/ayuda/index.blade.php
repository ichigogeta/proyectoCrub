@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-question"></i>
        Ayuda e información sobre el uso de la plataforma
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div id="box-ayuda" class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="row">
                        <div class="col-md-12">
                            <br /><br />
                            <ul class="lista-links">
                                <li>
                                    <a href="#tablero">
                                        Tablero
                                    </a>
                                </li>

                                <li>
                                    <a href="#noticias">
                                        Noticias
                                    </a>
                                </li>

                                <li>
                                    <a href="#paginas">
                                        Páginas
                                    </a>
                                </li>

                                <li>
                                    <a href="#constructor">
                                        Constructor
                                    </a>
                                </li>

                                <li>
                                    <a href="#slides">
                                        Slides
                                    </a>
                                </li>

                                <li>
                                    <a href="#editor-contenido-avanzado">
                                        Aprender a usar el editor Avanzado
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <br /><br />

                    <div class="panel-body">
                        <h2>
                            ¿Cómo administrar la intranet de una web corporativa?
                        </h2>

                        <div id="tablero" class="col-md-12">
                            <h3>Tablero</h3>
                            Es la primera pestaña de las que aparecen a la izquierda. Al pulsar en
                            ella, puedes ver tu tablero, dividido en ‘Noticias’ y ‘Páginas’ (las
                            explicaremos en puntos siguientes).
                            <br /><br />
                            <img class="ayuda-image" src="{{asset('img/intranet/ayuda/1.jpg')}}">
                            <br /><br />
                        </div>

                        <div id="noticias" class="col-md-12">
                            <h3>Noticias</h3>
                            Al pinchar sobre esta pestaña, se te abrirá la lista de noticias de tu
                            página web.
                            <br /><br />
                            <img class="ayuda-image" src="{{asset('img/intranet/ayuda/2.jpg')}}">
                            <br /><br />
                            Aquí puedes crear, editar y eliminar noticias de tu sitio para
                            actualizarlo periódicamente con el contenido que tú quieras, de
                            forma muy sencilla.
                            <br /><br />
                            <img class="ayuda-image" src="{{asset('img/intranet/ayuda/3.jpg')}}">
                            <br /><br />
                            Aquí debes añadir un título, un contenido de la noticia y un extracto
                            (breve entradilla que aparecerá bajo el título). A la derecha, puedes
                            añadir las palabras que aparecerán en la URL de la noticia, así como
                            el estado del post (‘publicado’, ‘borrador’ o ‘pendiente’) y la
                            categoría donde meterlo.
                            <br /><br />
                            Luego, en ‘Contenido SEO’, puedes añadir una metadescripción
                            breve y las palabras clave que quieras para que los buscadores
                            encuentren tu noticia. De igual forma, puedes poner una imagen
                            destacada.
                            <br /><br />
                            Una vez hayas puesto todo lo que quieres, le damos a ‘Crear nueva
                            noticia’ y listo.
                            <br /><br />
                        </div>

                        <div id="paginas" class="col-md-12">
                            <h3>Páginas</h3>
                            El funcionamiento es muy similar al de las noticias, con la diferencia
                            que estas publicaciones son páginas estáticas (del tipo ‘Sobre
                            nosotros’) atemporales. Los campos a rellenar son prácticamente los
                            mismos que los de las noticias.
                            <br /><br />
                            <img class="ayuda-image" src="{{asset('img/intranet/ayuda/4.jpg')}}">
                            <br /><br />
                            En la pantalla que aparece sobre estas líneas puedes ver el panel de
                            creación de una página. Una vez esté todo relleno, activamos el
                            estado ‘Active’, pulsamos sobre ‘Guardar’ y listo.
                            <br /><br />
                        </div>

                        <div id="constructor" class="col-md-12">
                            <h3>Herramientas>Constructor de menú</h3>
                            En este apartado, podrás editar el menú directamente dependiendo
                            del sitio web y del rol que tengas en él.
                            <br /><br />
                        </div>

                        <div id="slides" class="col-md-12">
                            <h3>Slides</h3>
                            Aquí podrás ver la lista de slides que hay en tu página web. Los
                            slides son las imágenes que van pasando de forma automática a
                            modo de carrusel. Podrás añadir, editar y borrar las que quieras.
                            <br /><br />
                            <img class="ayuda-image" src="{{asset('img/intranet/ayuda/5.jpg')}}">
                            <br /><br />
                            Al añadir una nueva, podrás (si quieres) ponerle un título,
                            descripción, texto del botón y URL (al que se le añade un # si no
                            quieres que vaya a ninguna otra dirección). Por supuesto, deberás
                            poner la imagen que quieras que se vea. Posteriormente, pulsamos
                            en guardar y listo.
                            <br /><br />
                        </div>

                        <div id="editor-contenido-avanzado"  class="col-md-12">
                            <h3>Editor de Contenido Avanzado</h3>
                            <br /><br />
                            <video style="width: 100%" controls>
                                <source src="{{asset('video/intranet/ayuda/contentbuilder-xerintel-demo.mp4')}}"
                                        type="video/mp4">
                                Tu navegador no soporta la etiqueta de vídeo
                            </video>
                            <br /><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    #box-ayuda {
        color: #000;
    }

    .ayuda-image {
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    .panel-body > div {
        margin-top: 40px;
        padding-left: 30px;
        padding-right: 30px;
    }
    .lista-links {
        list-style: none;
    }

    .lista-links li {

    }

    .lista-links li a {
        font-size: 1.4em;
        font-weight: bold;
    }
</style>
