@extends('layouts.layout')
@section('title', 'Категории')
@section('content')
    <div class="container">
        <div class="starter-template">
            @foreach($categories as $category)
                <div class="panel">
                    <a href="{{route('category', $category->code)}}">
                        <img src="{{$category->image}}">
                        <h2>{{$category->name}}</h2>
                    </a>
                    <p>
                        {{$category->description}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
