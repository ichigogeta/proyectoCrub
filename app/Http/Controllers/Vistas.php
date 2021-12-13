<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class Vistas extends Controller
{
    public function mostrarListaUsuarios(){
        $usuarios = User::all();
        return view('listaUsuarios',compact('usuarios'));
    }

    public function mostrarFormulario(){
        return view('formulario');
    }
}
