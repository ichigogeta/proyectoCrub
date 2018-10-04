<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;

class PageController extends Controller
{
    public function read($id)
    {
        $page = Page::findOrFail($id);

        return view('page', ['post' => $page]);

    }
}
