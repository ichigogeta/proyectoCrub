<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public $timestamps = false; //false significa no usar fechas de creación y modificación en la tabla. default=true.

    public static function todos()
    {
        return self::whereActive(1)->orderBy('orden')->get();
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
