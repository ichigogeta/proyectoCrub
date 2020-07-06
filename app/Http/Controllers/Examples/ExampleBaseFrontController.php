<?php

namespace App\Http\Controllers;

/**
 * Class ExampleBaseFrontController
 *
 *
 *
 * Ejemplo de uso para la clase que extiende de BaseFrontController.
 *
 *
 *
 * @package App\Http\Controllers
 */
class ExampleBaseFrontController extends Controller
{
    /**
     * Nombre del modelo/clase para este controlador.
     *
     * @var string
     */
    public $model = '\App\Project';

    /**
     * Nombre en singular para la variable que se pasará a las vistas.
     *
     * @var string
     */
    public $varSingular = 'project';

    /**
     * Nombre en plural para la variable que se pasará a las vistas.
     *
     * @var string
     */
    public $varPlural = 'projects';

    /**
     * Nombre en singular del modelo, para usarlo en mensajes de error o de
     * advertencia y suceso.
     *
     * @var string
     */
    public $singleName = 'Proyecto';

    /**
     * Nombre en plural del modelo, para usarlo en mensajes de error o de
     * advertencia y suceso.
     *
     * @var string
     */
    public $pluralName = 'Proyectos';
}

