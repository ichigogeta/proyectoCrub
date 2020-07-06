<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use function auth;

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
}
