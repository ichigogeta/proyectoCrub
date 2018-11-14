<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use URL;

class LanguageController extends Controller
{
    public function setLocale($locale = 'es')
    {
        Session::put('locale', $locale);
        return redirect(url(URL::previous()));
    }
}