<x-layout>
    @foreach($posts as $post)
    <div>
    <p>{{$post->id}}</p>
    <p>
    <a href="{{ route('posts.show', $post->id) }}">
        {{$post->title}}
    </a>
    </p>
    <p>{{$post->user->name}}</p> 
    <p>{{$post->category->name}}</p> 
</div>
    @endforeach
</x-layout>