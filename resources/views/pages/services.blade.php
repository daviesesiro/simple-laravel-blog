@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>
    @if(count($services) > 0)
        <ul>
            @foreach ($services as $s)
                <li>{{ $s }}</li>
            @endforeach
        </ul>
    @endif
    <p>This is the Services page</p>
@endsection