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

Route::get('/noticias', 'PostController@listAll')->name('noticias');
Route::get('/noticias/{id}/{slug?}', 'PostController@read');
Route::get('/contacto', 'ContactoController@read')->name('contacto');
Route::post('/contacto', 'ContactoController@send');

Route::get('/pagina/{slug}', 'PageController@read');


Route::group(['prefix' => 'intranet'], function () {
    Voyager::routes();
});


Auth::routes(); //Rutas de login sin direccionarte a la intranet y con registro público


/* Multilenguaje
 * Tendrás de descomentarme de app/http/kernel.php
 */
//Route::get('locale/{locale}','LanguageController@setLocale')->where('locale','en|es');


/*
Route::get('/home', 'HomeController@index')->name('home');
*/