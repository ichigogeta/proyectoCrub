<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class SimpleModel extends Model
{
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
}
