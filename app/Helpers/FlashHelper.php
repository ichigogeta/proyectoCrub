<?php
/**
 * Created by PhpStorm.
 * User: Javier Garcia
 * Date: 22/08/2017
 * Time: 15:25
 */

class FlashHelper
{
    /**
     * Todo correcto, cartel verde
     *
     * @param string $message mensaje a mostrar
     */
    public static function success($message)
    {
        FlashHelper::sendFlash('success', $message);
    }

    /**
     * Flash informativo, neutral
     *
     * @param string $message mensaje a mostrar
     */
    public static function info($message)
    {
        FlashHelper::sendFlash('info', $message);
    }

    /**
     * Flash Advertencia, amarillo/naranja
     *
     * @param string $message mensaje a mostrar
     */
    public static function warning($message)
    {
        FlashHelper::sendFlash('warning', $message);
    }

    /**
     * Flash peligro o error, rojo
     *
     * @param string message mensaje a mostrar
     */
    public static function danger($message)
    {
        FlashHelper::sendFlash('danger', $message);
    }

    private static function sendFlash($level, $message)
    {
        session()->flash('flash_notification', ['level' => $level, 'message' => $message]);
    }
}

