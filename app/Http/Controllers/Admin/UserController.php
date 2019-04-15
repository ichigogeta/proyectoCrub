<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class UserController extends VoyagerBaseController
{
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
