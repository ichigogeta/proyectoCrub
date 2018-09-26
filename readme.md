## About Laravel(Xerintel)
Duplica el fichero **.env.example** y llamalo solo **.env** y abrelo.  
Configura tu base de datos, url, nombre de la applicación, etc.  
Ahora instalamos la intranet:
```
php artisan xerintel:install
```
**OJO**, es posible que de error la primera vez, funcionará al segundo intento.

Si necesitas más usuarios:
```
php artisan voyager:admin your@email.com --create
```
**--create** Generará un usuario tipo admin, omítelo para crear usuarios normales.


## Configuraciones Básicas
Echa un ojo a tu fichero de rutas **web.php**, verás algo así
```
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
```
Reemplaza **admin** por tu prefijo deseado.

###Creando tablas
Cuidado con los plurales y singulares. El convenio dicta que las tablas tienen nombres en plural y los modelos en singular.  
Ejemplo: **el singular de Animales es Animale**, pero puedes llamar al modelo como quieras y especificarle la tabla dentro.
```
protected $table = 'animales';
```


###Permisos
Los usuarios pertenecen a grupos, y los grupos contienen los permisos.  
El grupo admin tiene todos los permisos por defecto, los demás tienen ninguno.  
Dale permisos en la pestaña **Roles**.  
**"Browse Admin"** es esencial para ver la intranet.


###Helpers
Verás que tienes una carpeta **App/Helpers**.  
Ahí puedes añadir tantos ficheros como quieras, crear clases estáticas o funciones directamente, pero ojo, no uses el nombre de otra función existente. 
Lo especial de los **helpers** es que están disponibles globalmente, incluso en las plantillas.

###BREAD
**B**rowse **R**ead **E**dit **A**dd **D**elete.  
El CRUD de toda la vida, con otro nombre y automático.



##Publicar web
Es necesario que sea PHP 7.x

Sube la base de datos y copia las credenciales al fichero .env y configuralo como production.  
Sube/clona el proyecto a la carpeta privada.  
```
chmod -R o+w milaravel/storage
```
Mediante enlace simbólico se enlaza la carpeta public de laravel con la de cPanel.

Si falla o sale en blanco, corre a mirar storage/laravel.log



<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel(Laravel Laravel)
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
