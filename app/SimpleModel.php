<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use function auth;
use function count;

abstract class SimpleModel extends Model
{
    protected $guarded = [
        'id'
    ];

    //public $timestamps = false; //false significa no usar fechas de creación y modificación en la tabla. default=true.
    //protected $table = 'mitabla';//Usar si la tabla tiene un nombre diferente al del modelo

    /**
     * @param string $success_msg mensaje de exito.
     * @return bool true=ok, false=error
     */
    public function store($success_msg = 'Todo Correcto.')
    {
        try {
            $this->save();
            \FlashHelper::success($success_msg);
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            \FlashHelper::warning('No se pudo guardar. Inténtelo más tarde o contacte con el administrador.');
            return false;
        }
    }

    /**
     * Reglas de validación para el modelo.
     */
    protected $rules = [];

    /**
     * Mensajes Personalizados para las reglas de validación.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Nombres personalizados para los atributos recibidos.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Valida campos recibidos antes de intentar el guardado.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateSave(Request $request)
    {
        $validatedData = Validator::make(
            $request->all(),
            $this->rules,
            $this->messages,
            $this->attributes
        );

        return $validatedData->validate();
    }


    /**
     * Guarda los datos de una request en el modelo actual.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeRequest(Request $request)
    {
        if (! $request->has('user_id') && !auth()->guest())
            $request->request->add([
                'user_id' => auth()->id(),
            ]);

        $validation = $this->validateSave($request);

        $this->fill($validation);
        $this->save();
    }

    /**
     * Devuelve la consulta filtrada sin ejecutar para obtener elementos
     * seguros.
     *
     * By Raúl Caro
     *
     * @param array $filter Recibe una matriz con los tipos de filtros dentro:
     *                      where => ['campo' => 'condicion'],
     *                      orWhere => ['campo' => 'condicion'],
     *                      whereNull => ['campo'],
     *                      whereNotNull => ['campo'],
     *
     * @return mixed
     */
    public function getAllFiltered($filter = [])
    {
        $model = self::whereNotNull('id');

        ## Proceso el filtro de condiciones obligatorias.
        if (isset($filter['where']) && count($filter['where'])) {
            foreach ($filter['where'] as $idx => $filtro) {
                if ($filtro != null) {
                    $model->where($idx, $filtro);
                }
            }
        }

        ## Proceso el filtro de condiciones para no null.
        if (isset($filter['whereNotNull']) && count($filter['whereNotNull'])) {
            foreach ($filter['whereNotNull'] as $ele) {
                $model->whereNotNull($ele);
            }
        }

        ## Proceso el filtro de condiciones para obligar campos null.
        if (isset($filter['whereNull']) && count($filter['whereNull'])) {
            foreach ($filter['whereNull'] as $ele) {
                $model->whereNull($ele);
            }
        }

        ## Proceso el filtro de condiciones opcionales
        if (isset($filter['orWhere']) && count($filter['orWhere'])) {
            $model->where(function ($query) use ($filter) {
                foreach ($filter['orWhere'] as $idx => $filtro) {
                    if ($filtro) {
                        $query->orWhere($idx, 'LIKE', '%'.$filtro.'%');
                    }
                }

                return $query;
            });
        }

        return $model;
    }
}
