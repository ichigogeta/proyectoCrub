<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function asset;
use function url;

class Slide extends Model
{
    protected $table = 'slides';

    public $timestamps = false; //false significa no usar fechas de creación y modificación en la tabla. default=true.

    /**
     * Devuelve todos los slides.
     *
     * @return mixed
     */
    public static function getAll()
    {
        return self::whereActive(1)->orderBy('orden')->get();
    }

    /**
     * Devuelve la ruta hacia la imagen del slide
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlImageAttribute()
    {
        return asset('storage/' . $this->image);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($item) {
            $tmp = self::orderBy('orden', 'desc')->first();
            if ($tmp) {
                $item->orden = $tmp->orden + 1;
            }
        });
    }
}
