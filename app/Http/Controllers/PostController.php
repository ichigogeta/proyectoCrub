<?php

namespace App\Http\Controllers;

use App\Post;

class PostController extends Controller
{

    public function listAll()
    {
        $posts = Post::whereStatus('PUBLISHED')->orderBy('created_at', 'desc')->paginate(3);
        //  dd($posts);
        return view('blog', ['posts' => $posts]);

    }


    public function read($id)
    {
        $post = Post::where('id', $id)->whereStatus('PUBLISHED')->firstOrFail();

        return view('post', ['post' => $post]);

    }
}
