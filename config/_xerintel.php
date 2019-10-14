<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Version de la aplicación
    |--------------------------------------------------------------------------
    |
    | CSS, JS, o imagenes, añade numero de versión a las rutas.
    | Y así evitar caché del cliente.
    |
    */
    'version' => 1,

    /*
    |--------------------------------------------------------------------------
    | Email del cliente
    |--------------------------------------------------------------------------
    |
    | Avisos, formularío de contacto y otras necesidades.
    |
    */
    'mail_cliente' => env('MAIL_TEST_ACCOUNT', 'cliente@example.com'),

    /*
    |--------------------------------------------------------------------------
    | Email de la aplicación
    |--------------------------------------------------------------------------
    |
    | Dirección email remitente de los emails enviados via PHP
    |
    */
    'app_mail' => 'app@example.com',

    /*
    |--------------------------------------------------------------------------
    | Nombre del email de la aplicación
    |--------------------------------------------------------------------------
    |
    | Aparece como nombre del remitente de los emails enviados via PHP
    |
    */
    'app_mail_name' => 'App Xerintel',

    /**
     * Redes Sociales.
     */
    'facebook' => 'https://www.facebook.com/xerintel',
    'instagram' => 'https://www.instagram.com/xerintel',
    'twitter' => 'https://twitter.com/xerintel',
    'linkedin' => 'https://www.linkedin.com/xerintel',
    'youtube' => 'https://www.youtube.com/xerintel',

    /**
     * Datos de la empresa.
     */
    'email' => 'app@example.com',
    'phone' => '+34 123 123 123',
    'name' => 'Xerintel',
    'address' => 'Dirección de ejemplo (Jerez), 123',

    ## Solo el src="" de google maps.
    'google_maps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3199.8070549645504!2d-6.132318684361408!3d36.6791398799735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0dc6ed249de6c7%3A0xaeebe6a61cef12ac!2sXerintel%20Internet%20Technologies%20SL!5e0!3m2!1ses!2ses!4v1568794755859!5m2!1ses!2ses'
];
