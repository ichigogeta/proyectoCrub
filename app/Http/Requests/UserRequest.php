<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|max:140',
            'email' => 'required|email',
            'password'=> 'required|min:1|confirmed',//CONFIRMAR LA CONTRASEÑA ES CONFIRMED PERO DESDE EL PASSWORD NO DESDE EL CONFIRM
            'password_confirmation'=> 'required'//TAMBIEN SE PUEDEN USAR EXPRESIONES HACIENDO "REGEX:expresionregular".
        ];
    }
}
