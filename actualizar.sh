#!/usr/bin/env bash
cd "${0%/*}"

echo "La web se pondrá en modo mantenimiento automaticamente. En caso de error, utiliza php artisan up"
php artisan down --message="Actualizando el servidor, por favor espere." --retry=60

git pull

composer install --no-interaction --no-dev

php artisan cache:clear #elimina el cache existentes, necesario si hay cambios de modelo-vista relaccionado con un cache.
php artisan auth:clear-resets #limpia los resets de contraseña caducados

#php artisan route:clear # Con estas dos lineas
#php artisan route:cache # No puedes tener rutas dinamicas. cuidado multidominios.

php artisan config:clear
php artisan config:cache

php artisan up