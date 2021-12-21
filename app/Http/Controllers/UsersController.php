<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    //Método para mostrar la lista de los usuarios.
    public function mostrarListaUsuarios()
    {
        $usuarios = User::all();//Creamos una variable y le pasamos todos los datos de la base de datos.
        return view('listaUsuarios', compact('usuarios'));//Devuelve la vista y le pasamos la variable de la base de datos para que la pueda usar.
    }

    //Método para mostrar el formulario.
    public function mostrarFormulario()
    {
        return view('formulario');
    }

    //Método para mostrar la vista confirmacion pasandole como parametro la id.
    public function mostrarConfirmacion(Request $request)
    {
        $usuario = User::find($request->user_id);
        $id = $request->user_id;
        //Muestra la vista de confirmacion para eliminar, pasandole unos parametros los cuales necesitamos para borrar el usuario.
        //Compact se usa para pasar informacion a la vista del return.
        return view('confirmacionEliminar',compact('id'));
    }

    //Método para crear el usuario.
    public function crearUsuario(UserRequest $request)
    {

        $rutaNuevaImagen = null;
        //dd(asset('avatars/'.$request->archivo));
        if(!empty($request->archivo)){
            $rutaNuevaImagen = asset('avatars/'.$request->archivo);
            Storage::copy('C:/Users/Ichigogeta/Desktop483Dialga.png',$rutaNuevaImagen);
            //NO ENTIENDO COMO COPIAR LA IMAGEN A LA NUEVA RUTA.

            //Intentos...:
            //$file = $request->file('archivo');
            //$file->move(base_path('\avatars'),$request->archivo);

        }
        User::create([//Creamos el usuario.
            'name' => $request->nombre,
            'email' => $request->email,
            'password'=> Hash::make($request['password']),
            'avatar'=> $rutaNuevaImagen
        ]);
        
        \FlashHelper::success("Usuario guardado exitosamente!");//Traemos de la clase FlashHelper creada en App\Helpers el metodo "success" y le indicamos una frase para que la muestre como confirmación.
        return redirect()->route('mostrarListaUsuarios');//Redirigimos a la Route el cual contiene un metodo.
    }

    //Método para eliminar usuario.
    public function eliminarUsuario(Request $request){
        //dd($request);
        //TODO=> Controlar existencia de usuario
        $usuario = User::find($request->id);//Encontramos el id.
        if(isset($usuario)){
            if($usuario->id == $request->id){
                $usuario->delete();//Borramos.
                \FlashHelper::success("Usuario eliminado exitosamente!");//Avisamos al usuario.
            }else{
                \FlashHelper::success("El usuario no es válido!");//Avisamos al usuario.
            }
            
        }else{
            \FlashHelper::danger("El usuario no existe!");//Avisamos al usuario.
        }
        
        
        return redirect()->route('mostrarListaUsuarios');//Redirigimos a la route el cual contiene un metodo y le pasamos un parametro.
    }

    //Método para mostra los datos en el formulario.
    public function mostrarEditarUsuario($id){
        $usuario = User::find($id);//Encontramos el id de ese usuario.
        $id = $usuario->id;
        $nombre = $usuario->name;//Igualamos para establecer el usuario y el email en sus campos.
        $email = $usuario->email;
        $password = $usuario->password;
        return view('formulario',compact('id','nombre','email','password'));//Devuelve el formulario pasandole unos parametros.
    }

    //Método para editar un usuario.
    public function editarUsuario(UserRequest $request){
        //TODO=> Controlar existencia de usuario
        $password = Hash::make($request['password']);
        $usuario = User::find($request->id);//Encontramos el id
        
        if(isset($usuario)){
            if($usuario->id == $request->id){//comprobamos el id.
                if(Hash::check($request->password,$usuario->password)){//HAS::CHECK ES PARA COMPROBAR LA CONTRASEÑA SI ES LA MISMA DE LA BBDD. 
                    $usuario->name = $request->nombre;//Establecemos el nombre y email nuevos en la base de datos.
                    $usuario->email = $request->email;
                    $usuario->save();//guardamos.
                    $usuario = User::all();//Recogemos todos los datos.
                    \FlashHelper::success("Usuario actualizado exitosamente!");//Avisamos al usuario.
                }else{
                    \FlashHelper::danger("La contraseña es incorrecta!");//Avisamos al usuario.
                }
            }else{
                \FlashHelper::danger("Usuario no válido!");//Avisamos al usuario.
            }
        }else{
            \FlashHelper::danger("El usuario no existe!");//Avisamos al usuario.
        }
        return redirect()->route('mostrarListaUsuarios');//Redirigimos la route que contiene un método.
    }
}
