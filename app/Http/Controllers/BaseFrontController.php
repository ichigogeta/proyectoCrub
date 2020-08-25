<?php

namespace App\Http\Controllers;

use App\Project;
use Exception;
use FlashHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function dd;
use function redirect;
use function view;

abstract class BaseFrontController extends Controller
{
    /**
     * Nombre del modelo/clase para este controlador.
     *
     * @var string
     */
    public $model;

    /**
     * Nombre en singular para la variable que se pasará a las vistas.
     *
     * @var string
     */
    public $varSingular;

    /**
     * Nombre en plural para la variable que se pasará a las vistas.
     *
     * @var string
     */
    public $varPlural;

    /**
     * Nombre en singular del modelo, para usarlo en mensajes de error o de
     * advertencia y suceso.
     *
     * @var string
     */
    public $singleName;

    /**
     * Nombre en plural del modelo, para usarlo en mensajes de error o de
     * advertencia y suceso.
     * @var string
     */
    public $pluralName;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view($this->varPlural . '.index')->with([
            $this->varPlural => $this->model::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        return view($this->varPlural . '.edit-add')->with([
            $this->varSingular => new $this->model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $model_id = $request->get($this->varSingular . '_id');

        if ($model_id) {
            $model = $this->model::find($model_id);
        } else {
            $model = new $this->model;
        }

        if (!$model) {
            FlashHelper::danger('No se ha encontrado el ' . $this->singleName);
            return redirect()->back();
        }

        $model->storeRequest($request);

        try {
        } catch (Exception $e) {
            FlashHelper::danger('No se ha podido guardar el ' . $this->singleName);
            Log::error('Error en el controlador ' . self::class . ' en método store()');
            Log::error($e);

            return redirect()->back();
        }

        dd($model, $request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($model_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($model_id)
    {
        $model = Project::find($model_id);

        if (!$model) {
            FlashHelper::danger('El proyecto que intentas editar no existe o no tienes permisos');
            return redirect()->back();
        }

        return view($this->varPlural . '.edit-add')->with([
            $this->varSingular => $model,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $model_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($model_id)
    {
        //
    }
}
