<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use function asset;

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
}
