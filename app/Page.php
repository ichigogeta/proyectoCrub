<?php

namespace App;


class Page extends \TCG\Voyager\Models\Page
{
    //

    public function getUrlAttribute()
    {
        return url('pagina/' . $this->id . '/' . $this->slug);
    }
}
