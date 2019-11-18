<?php

namespace App\Http\Controllers;

use App\Page;
use function view;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 'ACTIVE')->firstOrFail();

        return view('pages.show', ['page' => $page]);
    }
}
