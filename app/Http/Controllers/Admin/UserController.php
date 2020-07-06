<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BaseFiltradoController;
use App\User;
use Exception;
use FlashHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Log;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use function redirect;
use function view;

class UserController extends BaseFiltradoController
{
    /**
     * Añado filtro para que el usuario Xerintel quede protegido.
     * Los administradores pueden ver a todos menos a xerintel.
     * EL usuario Xerintel puede ver a todos.
     *
     * By Raúl Caro
     */
    protected function miFiltro(Builder $query)
    {
        $role_id = \auth()->user()->role_id;

        if ($role_id == 1) {
            return $query;
        } else if ($role_id == 3) {
            return $query->whereNotIn('role_id', [1]);
        }

        // Esta línea solo deja ver usuarios que no son administradores.
        //return $query->whereNotIn('role_id', [1, 3]);

        return $query->whereNotIn('role_id', [1]);
    }

    public function update(Request $request, $id)
    {
        $this->onlyAdminCanSetAdmin($request);
        $return = parent::update($request, $id);
        $return->setTargetUrl(URL::previous());
        return $return;
    }

    public function store(Request $request)
    {
        $this->onlyAdminCanSetAdmin($request);
        return parent::store($request);
    }

    public function suplantar($id)
    {
        $this->permissionCheck();
        $target = $this->getTargetUser($id);

        $real_id = Auth::id();
        Auth::logout();
        Auth::loginUsingId($id);
        session()->put('real_id', $real_id);

        return redirect()->route('voyager.dashboard');
    }

    private function permissionCheck()
    {
        if (Auth::user()->role_id != 1)
            $this->detectadaAccionProhibida();

    }

    /**
     * @param $id
     * @return User|User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function getTargetUser($id)
    {
        $target = User::findOrFail($id);
        if ($target->role_id == 1)
            $this->detectadaAccionProhibida();
        return $target;
    }

    private function onlyAdminCanSetAdmin(Request $request)
    {

        if (Auth::user()->role_id != 1) //no es admin
        {
            if ($request->get('role_id') == 1)
                $this->detectadaAccionProhibida();

            $array = $request->get('user_belongstomany_role_relationship');
            if (!empty($array))
                foreach ($array as $role) {
                    if ($role == 1)
                        $this->detectadaAccionProhibida();
                }

        }
    }

    private function detectadaAccionProhibida()
    {
        die('Detectada acción prohibida');
    }



    /********************   RUTAS PARA LA PARTE FRONT ********************/

    /**
     * Lleva a la vista del front para el formulario de crear usuarios.
     */
    public function frontCreate()
    {
        //return view('profiles.add-create');
    }

    /**
     * Procesa el formulario para crear usuario y lo guarda en la DB.
     */
    public function frontStore()
    {

    }

    /**
     * Lleva a la vista para mostrar un usuario.
     *
     * @param number $user_id El id del usuario a mostrar.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function frontShow($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            FlashHelper::danger('No existe el usuario que se intenta mostrar');
            return redirect()->back();
        }

        /*
        return view('profiles.show')->with([
            'user' => $user,
        ]);
        */
    }

    /**
     * Lleva a la vista para editar el usuario.
     *
     * By Raúl Caro
     *
     * @param number $user_id El id del usuario a editar.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function frontEdit($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            FlashHelper::danger('No existe el usuario que se intenta mostrar');
            return redirect()->back();
        }

        if (!User::canEdit($user_id)) {
            FlashHelper::danger('No tienes permisos para editar el usuario');
            return redirect()->back();
        }

        /*
        return view('profiles.edit-add')->with([
            'user' => $user,
        ]);
        */
    }

    /**
     * Procesa el guardado de un usuario que ya existía.
     *
     * By Raúl Caro
     *
     * @param \Illuminate\Http\Request $request
     * @param number $user_id El id del usuario para
     *                        actualizar.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function frontUpdate(Request $request, $user_id)
    {
        $validator = User::validateRequest($request);

        if ($validator && $validator->fails()) {
            FlashHelper::warning('No se ha cumplido la validación');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ## Busco el usuario.
        $user = User::find($user_id);

        ## En caso de no tener usuario se vuelve atrás.
        if (!$user) {
            FlashHelper::danger('No se encuentra el usuario que se intenta actualizar.');
            return redirect()->back();
        }

        try {
            ## Recorro cada atributo validado y lo asigno al usuario.
            foreach ($validator->validate() as $idx => $data) {
                if (!$data) {
                    continue;
                } else if ($data instanceof UploadedFile) {  ## Si es una subida de archivo
                    //$name = time() . uniqid() . md5(uniqid(rand(), true));

                    $user->{$idx} = $data->store('avatars', ['disk' => 'public']);
                } else if ($idx == 'password') {
                    $user->{$idx} = Hash::make($data);
                } else {
                    $user->{$idx} = $data;
                }
            }

            ## Guardo el usuario.
            $user->save();
            
        } catch (Exception $e) {
            Log::error('Error al procesar el guardado en el controlador UserController, función frontUpdate()');
            Log::error($e);

            FlashHelper::danger('Ha ocurrido un error al actualizar el usuario, si vuelve a ocurrir contacta con el administrador.');
            return redirect()->back();
        }

        FlashHelper::success('Se ha actualizado el usuario correctamente.');
        return redirect()->route('profile.show', ['user_id' => $user->id]);
    }
}
