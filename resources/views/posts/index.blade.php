@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts)>0)
        <div class="card">

            <ul class='list-group list-group-flush'>
                @foreach ($posts as $post)
                    <div class="row h-100">
                        <div class="col-md-4">
                            <img src="/storage/cover_images/{{$post->cover_image}}" alt="cover_image" style="width: 100%">
                        </div>
                        <div class="col-md-8">
                            <h3><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h3>
                            <small>Written on {{ $post->created_at }}</small>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    @endif


@endsection
