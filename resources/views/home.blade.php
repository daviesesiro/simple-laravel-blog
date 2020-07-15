@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class='btn btn-primary'>Create Post</a>
                    <h3>Your Posts</h3>
                    @if(count($posts)>0)
                        <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Edit</th>
                                {{-- <th></th> --}}
                            </tr>                        
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td><a href="/posts/{{ $post->id }}/edit" class='btn btn-default'>Edit</a></td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                        </table>
                    @else
                        <p>You do not have any post</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
