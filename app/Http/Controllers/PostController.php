<?php

namespace App\Http\Controllers;

use App\Post;

class PostController extends Controller
{

    public function listAll()
    {
        $posts = Post::orderBy('created_at')->paginate(3);
        //  dd($posts);
        return view('blog', ['posts' => $posts]);

    }


    public function read($id)
    {
        $post = Post::findOrFail($id);

        return view('post', ['post' => $post]);

    }
}
