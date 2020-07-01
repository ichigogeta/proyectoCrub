<?php
/**
 * Created by PhpStorm.
 * User: Javier Garcia
 * Date: 22/08/2017
 * Time: 15:25
 */

/**
 * Class AuxHelper
 * Helper con funciones auxiliares para obtener imágenes, rutas, cálculos...
 */
class AuxHelper
{
    /**
     * Devuelve una cadena verdaderamente única e inigualable 2 veces con un
     * coste de creación bastante bajo.
     * El resultado es algo similar a:
     * 1593633000191367dfa37740c065b64673407c160025d35bb17e2a63a1d1dcc7eac9feb78a
     */
    public static function uniqueId()
    {
        return time() . md5(uniqid(rand(), true)) . md5(uniqid(rand(), true));
    }
}
