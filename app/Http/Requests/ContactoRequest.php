<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoRequest extends FormRequest
{
    /**
     * Determina si el usuario tiene permiso suficientes.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Toma las normas de validación para esta Request.
     *
     * @return array
     */
    public function rules()
    {
        // https://laravel.com/docs/5.5/validation#available-validation-rules
        return [
            'nombre' => 'required|max:140',
            'email' => 'email',
            'cuerpo' => 'required',
            'condiciones' => 'accepted',
        ];
    }
    
    /*
    public function messages()
    {
        return [
            'accepted' => 'El campo :attribute debe ser aceptado'
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'email' => 'Email',
            'cuerpo' => 'Observaciones',
            'condiciones' =>'He leido y acepto la política de privacidad',
            'compania' => 'Compañía',
            'phone'=> 'Teléfono'
        ];
    }
    */
}
