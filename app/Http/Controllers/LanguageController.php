<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Session;
use URL;
use function in_array;
use function redirect;

class LanguageController extends Controller
{
    public function setLocale($locale = 'es')
    {
        if (!in_array($locale, ['es', 'en'])){
            $locale = 'es';
        }

        Session::put('locale', $locale);
        //App::setLocale($locale);

        return redirect(url(URL::previous()));
    }
}
