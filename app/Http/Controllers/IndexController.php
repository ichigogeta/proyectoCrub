<?php

namespace App\Http\Controllers;

use App\Post;

//use App\Slide;

class IndexController extends Controller
{
    public function index()
    {
        //$posts = Post::whereStatus('PUBLISHED')->orderBy('created_at', 'desc')->limit(3)->get();
        //$slides = Slide::where('active', 1)->orderBy('order')->get();

        return view('welcome');//, ['posts' => $posts]);//, 'slides' => $slides]);
    }
}
