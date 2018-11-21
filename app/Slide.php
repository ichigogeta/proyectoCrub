<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public $timestamps = false; //false significa no usar fechas de creacion y modificacion en la tabla. default=true.
    public $sortAsImage = true;
}