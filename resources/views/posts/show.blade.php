@extends('layouts.app')

@section('content')
    <a href="/posts" class='btn btn-primary'>Go Back</a>
    <h1 class="text-center">{{ $post->title }}</h1>
    <div class="row">
        <div class="col-md-12">
            <img src="/storage/cover_images/{{$post->cover_image}}" alt="cover image" class="img-fluid">
        </div>
    </div>
    <p>{{ $post->body }}</p>
    <hr>
    <small>Written on {{ $post->created_at }}</small>
    <a href="/posts/{{ $post->id }}/edit" class='btn btn-default'>Edit Post</a>

    @if(!Auth::guest() && Auth::user()->id == $post->user_id)
            <form action="/posts/{{ $post->id }}" method='post' class='ml-auto'>
                @csrf
                @method('DELETE')
                <button class='btn btn-danger'>Delete Post</button>
            </form>
    @endif
@endsection
