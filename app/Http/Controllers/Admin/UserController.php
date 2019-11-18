<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BaseFiltradoController;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class UserController extends BaseFiltradoController
{
    /**
     * Añado filtro para que el usuario Xerintel quede protegido y vea a todos.
     * Los administradores puede ver a todos menos a xerintel.
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
}
