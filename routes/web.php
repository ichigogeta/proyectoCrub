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


Auth::routes(); //Login y registro público. Comentar si no se necesita.

/* Multilenguaje
 * Tendrás de descomentarme de app/http/kernel.php
Route::get('locale/{locale}','LanguageController@setLocale')->where('locale','en|es');
*/
Route::group(['prefix' => 'intranet'], function () {
    Voyager::routes(); //Rutas de la intranet
});
