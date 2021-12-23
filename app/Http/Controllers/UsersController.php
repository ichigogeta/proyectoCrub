<?php

namespace App\Http\Controllers;
use App\User;//importar archivo de migracion para uso de bd
use Illuminate\Http\Request;//Request para el post de un formulario.
use App\Http\Requests\UserRequest;//Importar request para validar el post de un formulario.
use Illuminate\Support\Facades\Hash;//Necesario para cifrar contraseña.
use Illuminate\Support\Facades\Storage;//Necesario para guardar en el disco duro el archivo.
use Illuminate\Http\File;//Necesario para controlar el archivo.

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
        $path = null;//iniciamos el path en null
        if($request->hasFile('archivo')){//si el input file tiene archivo.
            $imagen = $request->file('archivo');//cogemos el input file arhivo.
            $path = $request->archivo->storeAs('avatars', $imagen->getClientOriginalName());//Indicamos la ruta donde se guardará
        }
        User::create([//Creamos el usuario.
            'name' => $request->nombre,
            'email' => $request->email,
            'password'=> Hash::make($request['password']),
            'avatar'=> $path
        ]);
        //Una vez creado el usuario indicamos si de nuevo hay archivo en input file
        if($request->hasFile('archivo')){//Si el usuario no se crea, la imagen tampoco.
            //Guardamos en la carpeta app/public/avatars/nombrearchivo.jpg
            //LA RUTA SE CONFIGURA EN EL ARCHIVO /CONFIG/FILESYSTEM
            Storage::disk('public')->putFileAs('avatars/',new File($imagen),$imagen->getClientOriginalName());
        }
        
        \FlashHelper::success("Usuario guardado exitosamente!");//Traemos de la clase FlashHelper creada en App\Helpers el metodo "success" y le indicamos una frase para que la muestre como confirmación.
        return redirect()->route('mostrarListaUsuarios');//Redirigimos a la Route el cual contiene un metodo.
    }

    //Método para eliminar usuario.
    public function eliminarUsuario(Request $request){
        //dd($request);
        //TODO=> Controlar existencia de usuario
        $usuario = User::find($request->id);//Encontramos el id.
        if(isset($usuario)){
            if($usuario->id == $request->id){//Si el id del user introducido esta en la bd
                $nombreImagen = substr(strrchr($usuario->avatar, "/"), 1);//se verifica su avatar.
                $imagenValida = Storage::disk('public')->delete('avatars/'.$nombreImagen);
                if($imagenValida){//Comprobamos si existe su imagen.
                    Storage::disk('public')->delete('avatars/'.$nombreImagen);//borramos si existe.
                }
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
        $path = $usuario->avatar;//iniciamos el path.
        
        if(isset($usuario)){
            if($usuario->id == $request->id){//comprobamos el id.
                if(Hash::check($request->password,$usuario->password)){//HAS::CHECK ES PARA COMPROBAR LA CONTRASEÑA SI ES LA MISMA DE LA BBDD. 
                    if($request->hasFile('archivo')){//si el input file tiene archivo.
                        $imagen = $request->file('archivo');//cogemos el input file arhivo.
                        $path = $request->archivo->storeAs('avatars', $imagen->getClientOriginalName());//Indicamos la ruta donde se guardará
                    }
                    $usuario->name = $request->nombre;//Establecemos el nombre y email nuevos en la base de datos.
                    $usuario->email = $request->email;
                    $usuario->save();//guardamos.
                    //Una vez editado el usuario indicamos si de nuevo hay archivo en input file
                    if($request->hasFile('archivo')){//Si el usuario se edita.
                        //Guardamos en la carpeta app/public/avatars/nombrearchivo.jpg
                        //LA RUTA SE CONFIGURA EN EL ARCHIVO /CONFIG/FILESYSTEM
                        $nombreImagen = substr(strrchr($usuario->avatar, "/"), 1);//se verifica su avatar.
                        $imagenValida = Storage::disk('public')->delete($usuario->avatar);//se comprueba la ruta de la imagen de la bd.
                        if($imagenValida){//Comprobamos si existe su imagen.
                            //Si no existe no se cambia ya que el usuario no escogio nueva imagen.
                            Storage::disk('public')->delete('avatars/'.$nombreImagen);//borramos si existe.
                            //creamos la nueva.
                            Storage::disk('public')->putFileAs('avatars/',new File($imagen),$imagen->getClientOriginalName());
                            $usuario->avatar = $path;//Se guarda el path creado.
                            $usuario->save();
                        }
                        
                    }
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
