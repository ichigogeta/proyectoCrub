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
Route::get('/locale/to/{code}/{route}', 'LanguageController@setLocaleAndRedirectToRoute')->name('locale.route.redirect');

##LAS ROUTAS ESTAN COMPUESTAS POR: ROUTE::GET('NOMBRERUTA','CONTROLADOR@METODO')->name('NOMBRE DEL ROUTE PARA SU USO.');
##SI QUEREMOS VALIDAR LA RUTA DEBEMOS AÑADIRLE A LA RUTA ->Route::get('saludos/{nombre?}, function($nombre = "Invitado"){return "Saludos $nombre";})->where ('nombre',"[EXPRESION REGULAR");




##Dirige a la vista plantilla de la lista.
Route::get('listaUsuarios', 'UsersController@mostrarListaUsuarios')->name('mostrarListaUsuarios');

##Crea el usuario y redirige a la ruta mostrarlistausuarios.
Route::post('add-usuario','UsersController@crearUsuario')->name('store.agregarUsuario');
##Muestra el formulario.
Route::get('showform','UsersController@mostrarFormulario')->name('show.form');
##Muestra la vista de confirmacion pasandole la id mediante un href.
Route::get('confirmForm/{id?}','UsersController@mostrarConfirmacion')->name('show.confirmForm');
##Elimina el usuario y redirige a la ruta de msotrarlistausuarios.
Route::post('showForm','UsersController@eliminarUsuario')->name('show.form.del');
##Busca el usuario y lo muestra en el formulario para editarlo.
Route::get('showform/{id?}','UsersController@mostrarEditarUsuario')->name('show.form.edit');
##Edita el usuario y redirige a la ruta de mostrarlistausuarios.
Route::post('editarUsuario','UsersController@editarUsuario')->name('store.editarUsuario');

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


## EJEMPLO DE RUTAS PARA UN CRUD
/*
 ## Proyectos
Route::group(['prefix' => 'project'], function () {
    ## Muestra el listado de todos los proyectos.
    Route::get('/index', 'ProjectController@index')->name('project.index');

    ## Muestra la vista de un proyecto concreto.
    Route::get('/show/{project_id}', 'ProjectController@show')->name('project.show');

    ## Mostrar la vista para crear un proyecto.
    Route::get('/create', 'ProjectController@create')->name('project.create');

    ## Guardar los datos del proyecto.
    Route::post('/store/{project_id?}', 'ProjectController@store')->name('project.store');

    ## Mostrar la vista para editar un proyecto.
    Route::get('/edit/{project_id}', 'ProjectController@edit')->name('project.edit');

    ## Actualiza los datos del proyecto.
    Route::post('/update/{project_id}', 'ProjectController@update')->name('project.update');
});
 */

############################################################
##                      RAÚL TESTS                        ##
############################################################

/**
 * En esta sección se añaden las rutas para probar o depurar cosas.
 * Si te interesa que siempre estén en desarrollo activas, usa el grupo
 * correspondiente, para depurar independiente del entorno se usa la variable
 * DEBUG del archivo .env.
 */

## Rutas de prueba habilitadas cuando se activa el debug en el .env
if (config('app.debug')) {
    Route::group(['prefix' => 'test'], function () {

    });
}

## Rutas de pruebas solo habilitadas en local para depurar.
if (config('app.env') != 'production') {
    Route::group(['prefix' => 'test'], function () {

    });
}
