<?php

namespace App\Http\Controllers;

use App\Page;

class PageController extends Controller
{

    public function read($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 'ACTIVE')->firstOrFail();

        return view('page', ['page' => $page]);

    }
}
