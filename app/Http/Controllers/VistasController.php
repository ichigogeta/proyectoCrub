<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\ContactoRequest;

class VistasController extends Controller
{
    //Método para mostrar la lista de los usuarios.
    public function mostrarListaUsuarios(){
		$baseDatos = User::all();//Creamos una variable y le pasamos todos los datos de la base de datos.
        return view('listaUsuarios', compact('baseDatos'));//Devuelve la vista y le pasamos la variable de la base de datos para que la pueda usar.
    }

    //Método para mostrar el formulario pasandole una información a editar o a agregar dependiendo si los valores son null o no.
    public function mostrarFormulario(ContactoRequest $datos){
            $tipoBoton = $datos->tipoBoton;
            $id = $datos->id;
            $usuario = $datos->usuario;
            $email = $datos->email;
        //Compact se usa para pasar informacion a la vista del return.
       return   view('formulario',compact('id','usuario','email','tipoBoton'));
    }

    public function mostrarConfirmacion(ContactoRequest $datos){//Muestra la vista de confirmacion para eliminar, pasandole unos parametros los cuales necesitamos para borrar el usuario.
            $tipoBoton = $datos->tipoBoton;
            $id = $datos->id;
            $usuario = $datos->usuario;
            $email = $datos->email;
        //Compact se usa para pasar informacion a la vista del return.
        return view('confirmacionEliminar',compact('id','usuario','email','tipoBoton'));
    }
}
