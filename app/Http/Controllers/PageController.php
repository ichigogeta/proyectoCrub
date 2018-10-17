<?php

namespace App\Http\Controllers;

use App\Page;

class PageController extends Controller
{
    public function read($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if ($page->status != 'ACTIVE')
            abort(404);

        return view('page', ['post' => $page]);

    }
}
