<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return view('post.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }
}
