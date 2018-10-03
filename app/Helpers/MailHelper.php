<?php

class MailHelper
{

    /**
     * @param $mail
     * @param string $mensaje
     * @return bool
     */
    public static function enviar($mail, $mensaje = 'Su email ha sido enviado.')
    {

        try {
            Mail::send($mail);
            \FlashHelper::success($mensaje);
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            \FlashHelper::warning('No se pudo enviar. Inténtelo más tarde o contacte con el administrador.');
            return false;
        }
    }

    /**
     * @param $mail
     * @return bool
     */
    public static function enviarSinFlash($mail)
    {

        try {
            Mail::send($mail);
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

}
