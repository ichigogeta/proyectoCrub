<?php

namespace App\Http\Controllers;

use App\Post;

//use App\Slide;

class IndexController extends Controller
{
    public function index()
    {
       // $posts = Post::whereStatus('PUBLISHED')->orderBy('created_at')->limit(3)->get();
        //El modelo slides aun no existe, el slider debe ser perfeccionado antes de ser incluido por defecto
        //$slides = Slide::orderBy('order')->get();

        return view('welcome');//, ['posts' => $posts]);//, 'slides' => $slides]);
    }
}
