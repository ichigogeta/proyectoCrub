<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function asset;
use function url;

class Post extends \TCG\Voyager\Models\Post
{
    /**
     * Devuelve el enlace hacia la página.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlAttribute()
    {
        return url('noticias/' . $this->id . '/' . $this->slug);
    }

    /**
     * Devuelve la url hacia la imagen de la página.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlImageAttribute()
    {
        return asset('storage/' . $this->image);
    }

    /**
     * Devuelve la fecha formateada en Español.
     *
     * @return string
     */
    public function getFechaAttribute()
    {
        $fecha = $this->created_at ?? null;

        if ($fecha) {
            return $fecha->format('d/m/Y');
        }

        return '';
    }
}
