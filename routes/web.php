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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/noticias', 'PostController@listAll')->name('noticias');
Route::get('/noticias/{id}/{slug?}', 'PostController@read');
Route::get('/contacto', 'ContactoController@read')->name('contacto');
Route::post('/contacto', 'ContactoController@send');

Route::get('/pagina/{id}/{slug?}', 'PageController@read');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
