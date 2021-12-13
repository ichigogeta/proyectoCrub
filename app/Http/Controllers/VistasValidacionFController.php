<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VistasValidacionFController extends Controller
{
    public function mostrarFormulario(){
        return view('validacionFormularioJS');
    }

    public function mostrarMensaje(){
        return view('mensajeValido');
    }
}
