<?php

class MailHelper
{

    /**
     * @param $mail
     * @return bool
     */
    public static function enviar($mail)
    {

        try {
            Mail::send($mail);
            \FlashHelper::success('Su email ha sido enviado.');
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
