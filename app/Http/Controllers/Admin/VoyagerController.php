<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;


class VoyagerController extends \TCG\Voyager\Http\Controllers\VoyagerController
{
    public function logout()
    {
        if (session()->get('real_id')) {
            $real_id = session()->get('real_id');
            Auth::logout();
            Auth::loginUsingId($real_id);
            session()->forget('real_id');
            return redirect()->route('voyager.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('voyager.login');
        }

    }

}
