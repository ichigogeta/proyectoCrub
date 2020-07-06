<?php

namespace App\Http\Controllers;

use Exception;
use FlashHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function redirect;

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

    public function store(Request $request)
    {
        $project = parent::store($request);

        if (!$project) {
            FlashHelper::danger('No se ha podido guardar el ' . $this->singleName);
            return redirect()->back();
        }

        try {
            $project->status = 2;
            $project->store();
        } catch (Exception $e) {
            Log::error('Error al asignar estado en ' . $this->model . ' método store()');
            Log::error($e);

            FlashHelper::danger('Error al Publicar ' . $this->singleName);

            return redirect()->back();
        }

        FlashHelper::success('Se ha guardado el ' . $this->singleName . ' correctamente.');

        return redirect()->route('profile.show', ['project_id' => $project->id]);
    }
}

