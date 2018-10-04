<?php

namespace App\Http\Controllers;

use App\Post;
use App\Slide;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::whereStatus('PUBLISHED')->orderBy('created_at')->limit(3)->get();
        $slides = Slide::orderBy('order')->get();

        return view('welcome', ['posts' => $posts, 'slides' => $slides]);
    }
}
