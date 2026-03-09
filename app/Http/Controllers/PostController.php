<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request, Post $post){
    $posts = Post::with(['user', 'category'])->get();


        return view('posts.index', compact('posts'));
    }

    public function show(Request $request, Post $post){
        $post->load(['user', 'category', 'comments', 'comments.user']);

        return view('posts.show', compact('post'));
       
    }
}
