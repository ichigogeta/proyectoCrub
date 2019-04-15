#!/usr/bin/env bash

echo "Iniciado configurador. Esto puede tardar unos minutos."
sleep 0.5
echo "Recuerda haber creado la base de datos, y copiar las claves."
sleep 0.5
echo "¿Es correcta la url de la aplicación?"
sleep 0.5
echo "¿Está el debug en false?"

git config --global user.email "proyectos@xerintel.es"
git config --global user.name "Xerintel Proyectos"
composer install --no-dev
php artisan xerintel:repair

echo "Fin del script."