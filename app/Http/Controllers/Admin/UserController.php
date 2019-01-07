<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class UserController extends VoyagerBaseController
{
    public function update(Request $request, $id)
    {
        $this->onlyAdminCanSetAdmin($request);
        return parent::update($request, $id);
    }

    public function store(Request $request)
    {
        $this->onlyAdminCanSetAdmin($request);
        return parent::store($request);
    }

    public function suplantar($id)
    {
        if (Auth::user()->role_id == 1) {
            Auth::logout();
            Auth::loginUsingId($id);
        }
        return redirect()->route('voyager.dashboard');
    }

    private function onlyAdminCanSetAdmin($request)
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
