<?php

namespace App\Http\Controllers;

use App;
use Exception;
use Illuminate\Http\Request;
use Log;
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

    /**
     * Cambia el idioma de la sesión y luego redirige a la url indicada.
     *
     * By Raúl.
     *
     * @param string $locale Idioma al que traducir la sesión.
     * @param string $path Directorio dentro de la web partiendo de la raíz del
     *              dominio.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocaleAndRedirect($locale, $path)
    {
        $parent = $this->setLocale($locale);

        if ($path == 'home') {
            return redirect()->to(url('/'));
        }
        return redirect()->to(url($path));
    }

    /**
     * Cambia el idioma de la sesión y luego redirige generando la ruta a
     * partir del nombre de ruta recibido como segundo parámetro.
     *
     * By Raúl.
     *
     * @param string $locale Idioma al que traducir la sesión.
     * @param string $route Nombre de la ruta hacia el que redirigir después.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocaleAndRedirectToRoute($locale, $route)
    {
        $parent = $this->setLocale($locale);

        try {
            return redirect()->route($route);
        } catch (Exception $e) {
            Log::error('Error en la ruta recibida en LanguageController, función setLocaleAndRedirectToRoute()');
            Log::error($e);
        }

        return redirect()->route('home');
    }
}
