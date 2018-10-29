@extends('layouts.app')

{{--
Esto tiene su razon de ser
Normalmente es necesario usar un contenedor para todos los errores.
Usando el padre nos ahorramos reeescribirlo en cada error.


--}}

@section('content')
    <div class="row">
        <div class="col-md-6 text-center col-md-offset-3">
            @yield('mensaje')
        </div>
    </div>
@endsection