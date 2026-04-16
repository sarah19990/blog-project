<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {

        $validated = $request->validate([
            'content' => 'required|max:500'
        ]);

        $comment = new Comment();
        $comment->content = $validated['content'];

        $comment->parent_id = $request->parent_id ?? null;
        
        $comment->user_id = auth()->id();
        $post->comments()->save($comment);

        return redirect()->back()->with('success', 'Comment created successfully');

    }

    public function destroy(Comment $comment){
      if($comment->user_id !== auth()->id())
        {
            abort(403);
        }
      $comment->delete();

      return redirect()->back()->with('success', 'Comment deleted successfully');
    }

    public function update(Request $request, Comment $comment){
        if ($comment->user_id !== auth()->id())
            {
                abort(403);
            }
        $validated = $request->validate([
            'content' => 'required|max:500'
        ]);

        $comment->content = $validated['content'];

        $comment->save();

        return redirect()->back()->with('success', 'Comment updated successfully');
    }

    public function like(Comment $comment){
        $comment->increment('likes');

        return redirect()->back()->with('success', 'Like updated successfully');
    }

    public function dislike(Comment $comment){
        if($comment->likes > 0){
        $comment->decrement('likes');
        }
        return redirect()->back()->with('success', 'Like removed successfully');
    }

    public function report(Comment $comment){
        $comment->reports += 1;

        if($comment->reports >= 5){
            $comment->hidden = true;
        }

        $comment->save();
        
        return redirect()->back()->with('success', 'Comment reported successfully');
    }

    public function pin(Comment $comment){
        Comment::where('post_id', $comment->post_id)->update(['pinned' => false]);
        $comment->pinned = true;
        $comment->save();

        return redirect()->back()->with('success', 'Comment pinned sucessfully');
    }
}
