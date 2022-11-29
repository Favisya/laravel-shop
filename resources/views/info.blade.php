@extends('layout')
@section('content')
    {{$info->tittle}}
    {{$info->created_at}}

    {{$info->body}}

    <a href="/bio/info">
        fuck go back
    </a>
@endsection
