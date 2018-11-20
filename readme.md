## Acerca de Laravel(Xerintel)
[Laravel](https://laravel.com/docs/5.7/)(Framework) y [Voyager](https://voyager.readme.io/docs)(intranet).  
Este Readme.md es introductorio y no se garantiza que esté adecuadamente actualizado.  
Es preferible que consultes el confluence de la empresa.

###¿Qué ofrecen Laravel y Voyager?
Rutas con  php, no más .htaccess  
Separar el diseño de la lógica, para que puedas copiar y pegar a gusto.  
Validación más sencilla con auto respuesta al usuario.  
MultiLenguaje.  
Login de usuarios con modulo de permisos por grupos.  
Una intranet(Voyager) que se genera a si misma.  
Todas las tareas programadas parten del mismo .php  
Menor uso de phpMyadmin.  
Posibilidad de autocompletado en el IDE.  
Todos los ficheros sigue siendo .php, menos los .js .css .png pero ya me entendeis.

##Instalación
Descomprime/clona el proyecto base.  
Copia el fichero **.env.example** como **.env** y ábrelo.  
Configura tu base de datos, url, nombre de la aplicación, etc.  
```
composer install
```
Ahora instalamos la intranet:
```
php artisan xerintel:install
```

Si necesitas más usuarios:
```
php artisan voyager:admin your@email.com --create
```
**--create** Generará un usuario tipo admin, omítelo para crear usuarios normales.


## Configuraciones Básicas
Echa un ojo a tu fichero de rutas **web.php**, verás algo así
```
Route::group(['prefix' => 'intranet'], function () {
    Voyager::routes();
});
```
Reemplaza **intranet** por tu prefijo deseado.

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
El CRUD de toda la vida, con otro nombre y casi 100% automático.



##Publicar web
Es necesario PHP 7.1+

1) Sube la base de datos.  
2) Sube/clona el proyecto a la carpeta privada. O sube un zip en la carpeta al FTP y descomprimelo si todo falla.  
3) Recuerda usar el .env lo menos posible, para el servidor esas configuraciones deberian estar en la carpeta config.  
4) Sube los ficheros de storage/app via FTP porque estos no van en control de versión  
5) Cambia la url a la del proyecto.  
6) Enlace simbólico a la carpeta public de laravel con la de cPanel.  
7) Abre la intranet, si tiene errores o no sale nada, mira en storage/logs/laravel.log



<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

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

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
