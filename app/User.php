<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Validator;
use function asset;
use function auth;
use function in_array;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        if (!$this->provider) //provider se usa en logins sociales
            $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Genera la ruta hacia el avatar del usuario y lo devuelve.
     *
     * @return string Url hacia el avatar del usuario.
     */
    public function getUrlImageAttribute()
    {
        return $this->urlAvatar();
    }

    /**
     * Devuelve el enlace hacia el avatar del usuario.
     *
     * @return string
     */
    public function getUrlAvatarAttribute()
    {
        return asset('storage/' . $this->avatar);
    }

    /**
     * Devuelve si el usuario actual puede editar a otro usuario.
     * Puede editar en caso de ser administrador o ser el usuario actual con
     * el que está logueado en este momento.
     *
     * @param number $user_id Recibe el id del usuario a comprobar
     *
     * @return bool
     */
    public static function iCanEdit($user_id)
    {
        $role_id = auth()->user()->role_id;
        $my_id = auth()->id();

        return in_array($role_id, [1, 3]) || ($my_id == $user_id);
    }

    /**
     * Devuelve si el usuario actual puede eliminar a otro usuario.
     * En principio se aplican las mismas restricciones que para editar.
     *
     * @param number $user_id Recibe el id del usuario a comprobar.
     *
     * @return bool
     */
    public static function iCanDelete($user_id)
    {
        return self::canEdit($user_id);
    }

    /**
     * Valida campos recibidos en un objeto request de un formulario.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    public static function validateRequest(Request $request)
    {
        /**
         * Reglas de validación para el modelo de páginas.
         */
        $rules = [
            'avatar' => 'nullable|max:2048|mimes:jpeg,gif,png',
            'name' => 'required',
            //'nick' => 'required',
            //'birthday' => 'required',
            //'description' => 'required',
            //'email' => 'required',
        ];

        $messages = [
            'avatar.max' => 'El campo :attribute no puede ser superior a :max KB.',
            'avatar.mimes' => 'El campo :attribute solo puede tener formato jpg, png y gif',
            //'nick.unique' => 'El campo :attribute debe ser único, cada usuario debe tener una nick único.',
            //'nick.require' => 'El campo :attribute es obligatorio.',
        ];

        $attributes = [
            'avatar' => 'Avatar',
            'name' => 'Nombre',
            //'nick' => 'Nick',
            //'birthday' => 'Cumpleaños',
            //'description' => 'Descripción',
            'email' => 'Dirección Email',
        ];

        $validatedData = Validator::make(
            $request->all(),
            $rules,
            $messages,
            $attributes
        );

        return $validatedData;
    }
}
