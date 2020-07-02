<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'IndexController@index')->name('home');

## Posts
Route::get('/noticias', 'PostController@index')->name('noticias');
Route::get('/noticias/{id}/{slug?}', 'PostController@show');

## Contacto
Route::get('/contacto', 'ContactoController@read')->name('contacto');
Route::post('/contacto', 'ContactoController@send');

## Página
Route::get('/pagina/{slug}', 'PageController@show')->name('pagina');

## Cambia el idioma y vuelve a la misma página.
Route::get('/language/{code?}', 'LanguageController@setLocale')->name('language');

## Cambia el idioma y redirige a otra página.
Route::get('/locale/{code}/{path}', 'LanguageController@setLocaleAndRedirect')->name('locale.redirect');

## Cambia el idioma y redirige a otro lugar recibiendo el nombre (name) de esa ruta.
Route::get('/locale/{code}/{route}', 'LanguageController@setLocaleAndRedirectToRoute')->name('locale.route.redirect');




## Perfil del usuario
/*
Route::group(['prefix' => 'profile'], function () {
    ## Mostrar el perfil de un usuario.
    Route::get('/show/{user_id}', 'UserController@frontShow')->name('profile.show');

    ## Mostrar la vista para editar un usuario.
    Route::get('/edit/{user_id}', 'UserController@frontEdit')->name('profile.edit');

    ## Guardar los datos del usuario.
    Route::post('/update/{user_id}', 'UserController@frontUpdate')->name('profile.update');
});
*/


/*
Route::get('politica-de-privacidad', function () {
    return redirect()->route('pagina', ['slug' => 'politica-de-privacidad']);
})->name('privacity');
*/

Auth::routes(); //Login y registro público. Comentar si no se necesita.

/* Multilenguaje
 * Tendrás de descomentarme de app/http/kernel.php
Route::get('locale/{locale}','LanguageController@setLocale')->where('locale','en|es');
*/
Route::group(['prefix' => 'intranet'], function () {
    Route::group(['middleware' => 'admin.user'], function () {
        Route::get('/users/suplantar/{id}', 'UserController@suplantar')->name('intranet.user.suplantar');
        Route::any('/cms/imagesave', 'Admin\VoyagerController@saveImage')->name('intranet.contentbuilder.saveimage');
        Route::get('/ayuda', function () {
            return view('vendor.voyager.ayuda.index');
        })->name('ayuda');
    });
    Voyager::routes(); //Rutas de la intranet
});


## Logins sociales. Descomentar también en config/services.php.
/*
Route::get('/login/{social}', 'Auth\LoginController@socialLogin')->where('social', 'facebook|google');
Route::get('/login/{social}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'facebook|google');
 */






############################################################
##                       RAÚL TESTS                       ##
############################################################

## Rutas de prueba habilitadas cuando se activa el debug en el .env
if (config('app.debug')) {
    Route::group(['prefix' => 'test'], function () {

    });
}

## Rutas de pruebas solo habilitadas en local para depurar.
if (config('app.env') != 'production') {
    Route::group(['prefix' => 'test'], function () {

        ## Stripe
        Route::get('/stripe', function () {
            return StripeHelper::payForm(100, 'Concepto de pago');

            return auth()->user()->defaultCard();
            return view('update-payment-method', [
                'intent' => auth()->user()->createSetupIntent()
            ]);
        });

    });
}
