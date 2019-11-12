<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function asset;
use function strip_tags;
use function url;
use Illuminate\Support\Str;

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

    /**
     * Devuelve la cantidad de posts recibidos ordenados y paginados.
     *
     * @param int $limit
     *
     * @return mixed
     */
    public static function getNPaginate($limit = 4)
    {
        return self::whereStatus('PUBLISHED')
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * Devuelve el cuerpo sin etiquetas html y limitado a la cantidad de
     * carácteres recibidos.
     *
     * @param int    $limit Cantidad de carácteres a limitar.
     * @param string $final Final del párrafo.
     *
     * @return mixed
     */
    public function getBodyClean($limit = 250, $final = '...')
    {
        return Str::limit(strip_tags($this->body), $limit, $final);
    }
}
