<x-layout>
    <div>
        <h1>
        {{$post->title}}
        </h1>
        <p>
        {{$post->content}}
        </p>
        <p>Author:
        {{$post->user->name}}
        </p>
        <p>Category:
        {{$post->category->name}}
        </p>
        <h3>Comments</h3>
        @foreach($post->comments as $comment)
        @if($comment->hidden)
        <p>This comment has been hidden.</p>
        @else
        @if(request('edit') == $comment->id)
        <form method="POST" action="{{route('comments.update', $comment)}}">
            @csrf
            @method('PATCH')

            <textarea name="content">{{ $comment->content }}</textarea>

            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror 
            
            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    @else

        <p>{{$comment->content}}</p>
        <p>{{$comment->user->name}}</p>
        <p>{{$comment->created_at->diffForHumans()}}</p>

        @if(auth()->id() === $comment->user_id)
        <a href="{{ route('posts.show', $post) }}?edit={{ $comment->id }}">
            Edit
        </a>

        <form method="POST" action="{{route('comments.destroy', $comment)}}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <form method="POST" action="{{route('comments.pin', $comment)}}">
         @csrf
         @method('PATCH')
         @if($comment->pinned)
        <button type="submit" class="btn btn-danger">Unpin</button>
        @else
        <button type="submit" class="btn btn-secondary">Pin</button>
        @endif
        </form>
        @if(auth()->user()->bookmarkedPosts->contains($post->id))
    <form method="POST" action="{{ route('posts.unbookmark', $post) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Unsave</button>
    </form>
@else
    <form method="POST" action="{{ route('posts.bookmark', $post) }}">
        @csrf
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endif
        @if ($comment->likes > 0)
            <form method="POST" action="{{route('comments.dislike', $comment)}}">
                @csrf
            <button type="submit" class="btn btn-danger">Unlike</button>
</form>
        @else
        <form method="POST" action="{{route('comments.like', $comment)}}">
            @csrf
        <button type="submit" class="btn btn-primary">Like</button>
        </form>
        @endif
        <p>Likes: {{ $comment->likes }}</p>
        <form method="POST" action ="{{route('comments.report', $comment)}}">
            @csrf
        <button type="submit" class="btn btn-warning">Report</button>    
        </form>
        <p>Reports: {{ $comment->reports }}</p>
        <form method="POST"  action="{{route('comments.store', $post)}} ">
        @csrf
       <input type="hidden" name="parent_id" value="{{$comment->id}}"></input>
        <textarea class="form-control" name="content">{{ old('content') }}</textarea>
         @error('content')
         <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        <button type="submit" class="btn btn-primary">Reply</button>
       </form>
        @foreach($comment->replies as $reply)
        @if($reply->hidden)
            <p>This comment has been hidden.</p>
        @else
        <p style="margin-left: 20px;">
        {{ $reply->content }}
       </p>
       @endif
       @endforeach
        @endif
        @endforeach
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form method="POST"  action="{{route('comments.store', $post)}}">
            @csrf
        <div class="form-group">
        <label for="comment">Comment</label>
        <textarea class="form-control" name="content">{{ old('content') }}</textarea>
         @error('content')
         <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
         <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>  
   </div>
</x-layout>