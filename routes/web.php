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

/* Logins sociales
Route::get('/login/{social}', 'Auth\LoginController@socialLogin')->where('social', 'facebook|google');
Route::get('/login/{social}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'facebook|google');
 */
