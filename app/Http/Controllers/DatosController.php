<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Helpers;
use App\Http\Requests\ContactoRequest;

class DatosController extends Controller
{
  
    //Metodo que sirve para guardar datos en la base de datos usando un formulario.
    //Usamos request para recoger los names del formulario.
    //Usamos baseDatos como variable para acceder al modelo creado en nuestro proyecto(modelo que representa a la base de datos) Dicho modelo esta en APP\User.
    public function guardar(ContactoRequest $datos){//Usamos ContactoRequest porque es la clase creada en "App\Http\Requests\ContactoRequest."
                                                        //Con esto podemos validar los datos con el metodo rules automaticamente y ademas usar esa misma clase para guardar los datos en la base de datos.                                  //De otra forma tendriamos que crear la clase Request en esa carpeta o usarla llamandola "Request".
            //dd($datos->tipoBoton);
            if($datos->tipoBoton === "agregarUsuario"){
                //dd($datos->all());
                $baseDatos = new User;
                $baseDatos->name = $datos->usuario;
                $baseDatos->email = $datos->email;
                $baseDatos->save();//Usamos el metodo save para indicar que guardamos los datos en la base de datos.
                $baseDatos = User::all();//Usamos el metodo all para restacar directamente en el metodo todos los datos en una sola variable. 
                //dd($baseDatos);
                \FlashHelper::success("Usuario guardado exitosamente!");//Traemos de la clase FlashHelper creada en App\Helpers el metodo "success" y le indicamos una frase para que la muestre como confirmación.
            }elseif($datos->tipoBoton === "editarUsuario"){//Si pulsamos mediante un campo oculto el boton editar usuario.
                //dd($datos->email);
                $baseDatos = User::find($datos->id);//Encontramos el id de ese usuario.
                $baseDatos->name = $datos->usuario;//Igualamos para establecer el usuario y el email en sus campos.
                $baseDatos->email = $datos->email;
                $baseDatos->save();//Guardamos los datos.
                $baseDatos = User::all();//Recogemos todos los datos.
                \FlashHelper::success("Usuario actualizado exitosamente!");//Avisamos al usuario.
            }else{                //Si pulsa el boton eliminar mediante un campo oculto.
                $baseDatos = User::find($datos->id);//Encontramos el id.
                $baseDatos->delete();//Borramos.
                $baseDatos = User::all();//Cargamos todos los usuarios.
                \FlashHelper::success("Usuario eliminado exitosamente!");//Avisamos al usuario.
            }
                
            //TODOS ESTOS PASOS SE HAN REALIZADO CON CAMPOS OCULTOS PARA VERIFICAR DICHOS BOTONES, CAMPOS E INFORMACIONES.
        

        return view('listaUsuarios', compact('baseDatos'));//Devolvemos una vista y le pasamos la variable de la base de datos para que se pueda usar en la vista indicada.
    }

}
