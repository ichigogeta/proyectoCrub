<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends \TCG\Voyager\Models\Post
{
    //

    public function getUrlAttribute()
    {
        return url('noticias/' . $this->id . '/' . $this->slug);
    }
}
