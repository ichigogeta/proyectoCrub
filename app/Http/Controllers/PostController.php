<?php

namespace App\Http\Controllers;

use App\Post;

class PostController extends Controller
{

    /**
     * Muestra el listado con todas las noticias.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::whereStatus('PUBLISHED')->orderBy('created_at', 'desc')->paginate(3);

        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Muestra un post concreto.
     *
     * @param $id Recibe el id del post a mostrar.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::where('id', $id)->whereStatus('PUBLISHED')->firstOrFail();

        return view('posts.show', ['post' => $post]);
    }
}
