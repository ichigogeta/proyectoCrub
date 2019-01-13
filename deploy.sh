#!/usr/bin/env bash

##########################################
##            Objetivos                 ##
##########################################
## Despliega...

## Antes de comenzar es necesario:
## - Crear DB
## - Crear Usuario
## - Asignar usuario a DB
## - Cambiar versión php a 7.2 en **PHP Selector**
## - Cambiar en phpmyadmin la DB a Cotejamiento "utf8mb4_unicode_ci"
##

repositorio=''  ## Url del repositorio git
db_name=''  ## Nombre de la base de datos
db_user=''  ## Nombre del usuario para la base de datos
db_password=''  ## Contraseña de la base de datos
destino=''  ## Destino de la instalación → public_html|devxerintel
app_url=''  ## URL de la publicación

pedir_datos() {
    while [[ "$repositorio" = '' ]]; do
        clear
        echo 'Introduce la url del repositorio similar a: https://bitbuckets.org/loquesea.git'
        read -p '→ ' repositorio
    done
    
    while [[ "$db_name" = '' ]]; do
        clear
        echo 'Introduce el nombre la propia base de datos, por ejemplo: usuario_mysql'
        read -p '→ ' db_name
    done
    
    while [[ "$db_user" = '' ]]; do
        clear
        echo 'Introduce el nombre del usuario para la base de datos'
        read -p '→ ' db_user
    done
    
    while [[ "$db_password" = '' ]]; do
        clear
        echo 'Introduce la contraseña para el usuario de la base de datos'
        read -p '→ ' db_password
    done
    
    while [[ "$app_url" = '' ]]; do
        clear
        echo 'Introduce la url dónde se desplegará, por ejemplo: http://proyecto.devxerintel.net'
        read -p '→ ' app_url
    done
    
    while true :; do
        clear
        echo 'Selecciona si despliegas en public, en devxerintel o es multipremium:'
        echo '1) → public'
        echo '2) → devxerintel'
        echo '3) → Multipremium'
        read -p '→ ' destino
        
        if [[ "$destino" = '1' ]] || 
           [[ "$destino" = '2' ]]
           [[ "$destino" = '3' ]]; then
            break;
        fi
    done
}

prepararproyecto() {
    git clone $repositorio $HOME/laravel
    cd $HOME/laravel || exit 1
    
    if [[ ! -f $HOME/laravel/.env ]]; then
        cp $HOME/laravel/.env.example.production $HOME/laravel/.env
    fi

    php artisan key:generate
    composer install --no-dev
    php artisan xerintel:install
}

desplegar_public() {
    if [[ -d "$HOME/public_html" ]] && [[ -d "$HOME/laravel/public" ]]; then
        mv $HOME/public_html $HOME/old_public_html
        ln -s $HOME/laravel/public $HOME/public_html
    fi
    
    if [[ -h "$HOME/www" ]] && [[ -d "$HOME/public_html" ]]; then
        rm "$HOME/www"
        ln -s "$HOME/public_html" "$HOME/www"
    fi
}

desplegar_devxerintel() {
    if [[ -d "$HOME/public_html" ]]; then
        mv "$HOME/public_html" "$HOME/old_public_html"
        mkdir "$HOME/public_html"
    fi
    
    ln -s "$HOME/laravel/public" "$HOME/public_html/devxerintel"
    
    if [[ -h "$HOME/www" ]] && [[ -d "$HOME/public_html" ]]; then
        rm "$HOME/www"
        ln -s "$HOME/public_html" "$HOME/www"
    fi
}

desplegar_multipremium() {
    echo 'estamos en ello, aún no se despliega así :('
}

rellenar_variables_env() {
    local file_env="${HOME}/laravel/.env"
    ## TODO → Usar sed para escribir datos en el archivo .env
    #nano .env y Añadir usuarios/ruta DB
    # Ojo al siguiente ejemplo, para variables hay que cambiar delimitadores !!!
    #sed -r -i "s/^;?\s*DB_DATABASE\s*=.*$/DB_DATABASE=${db_name}/" $file_env
    echo "DB_DATABASE=$db_name" >> $file_env
    echo "DB_USERNAME=$db_user" >> $file_env
    echo "DB_PASSWORD=$db_password" >> $file_env
    echo "APP_URL=$app_url" >> $file_env
}

pedir_datos
exit 0
prepararproyecto

## Despliega según la selección introducida
if [[ "$destino" = "1" ]]; then
    desplegar_public
elif [[ "$destino" = "2" ]]; then
    desplegar_devxerintel
elif [[ "$destino" = "3" ]]; then
    desplegar_multipremium
fi

rellenar_variables_env

exit 0