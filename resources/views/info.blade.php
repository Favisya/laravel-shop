@extends('layout')
@section('content')
    <article>
        {{$info->title}}
        {{$info->created_at}}
    </article>
    <p>
        {{$info->body}}
    </p>

    <a href="/bio/info">
        fuck go back
    </a>
@endsection
