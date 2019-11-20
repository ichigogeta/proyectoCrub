<?php

namespace App\Http\Controllers;

use App\Post;
use function view;

//use App\Slide;

class IndexController extends Controller
{
    public function index()
    {
        //$posts = Post::getNPaginate(3);  ## Pasar número de posts a obtener
        //$slides = Slide::getAll();

        return view('home')->with([
            //'slides' => $slides,
        ]);
    }
}
