<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Admin\BaseFiltradoController;
use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use Validator;

class PageController extends BaseFiltradoController
{
    /**
     * Reglas de validación para el modelo de páginas.
     */
    protected $rules = [
        'image' => 'nullable|max:2048|mimes:jpeg,gif,png',
        'slug' => 'required',
    ];

    protected $messages = [
        'image.max' => 'El campo :attribute no puede ser superior a :max KB.',
        'image.mimes' => 'El campo :attribute solo puede tener formato jpg, png y gif',
        'slug.unique' => 'El campo :attribute debe ser único, cada página debe tener una url única.',
        'slug.require' => 'El campo :attribute es obligatorio.',
    ];

    protected $attributes = [
        'image' => 'Imagen',
        'slug' => 'Slug'
    ];

    /**
     * Valida campos recibidos antes de intentar el guardado.
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

    public function update(Request $request, $id)
    {
        $this->validateSave($request);

        return parent::update($request, $id);
    }

    public function store(Request $request)
    {
        $this->validateSave($request);

        return parent::store($request);
    }
}
?>
