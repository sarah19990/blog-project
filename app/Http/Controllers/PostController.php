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
        $post->load(['user', 'category',
        
        'comments' => function($query){
            
            $query->orderBy('pinned', 'desc')->orderBy('created_at', 'desc');
        },

        'comments.user'

        ]);
        
        return view('posts.show', compact('post'));
       
    }

    public function bookmark(Request $request, Post $post){
        $user = $request->user();

        $user->bookmarkedPosts()->syncWithoutDetaching([$post->id]);

        return redirect()->back()->with('success', 'Post bookmarked successfully');

    }


    public function unbookmark(Request $request, Post $post){
        $user = $request->user();

        $user->bookmarkedPosts()->detach($post->id);

        return redirect()->back()->with('success', 'Post unbookmarked successfully');
    }
    
    
}
