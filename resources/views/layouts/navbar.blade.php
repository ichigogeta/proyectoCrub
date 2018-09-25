<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Xerintel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav"></ul>
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Herramientas<span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        <li><a href="<?= url('/tools/text2string'); ?>">Text to String</a></li>
                        <li><a href="<?= url('/tools/easypass'); ?>">Generador de contraseñas</a></li>

                        {{--<li><a href="{{url('/tools/citar')}}">Pon algo bonito</a></li>--}}

                        {{--
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Descargables</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                        --}}
                    </ul>
                </li>
                <li><a href="<?= url('/contacto'); ?>">Contacto</a></li>
                <li><a href="<?= url('/aboutme'); ?>">Sobre Mí</a></li>

            </ul>

            <!-- Right Side Of Navbar -->
                @include('layouts.right_menu')

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?= url('/admin'); ?>">Ir a la intranet</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


