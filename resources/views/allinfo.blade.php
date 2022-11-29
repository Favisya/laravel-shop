@extends ('layout')
@section('content')
@foreach ($blocks as $block)
<article>
    <a href="/bio/info/{{$block->id}}" >
        {{$block->title}}
    </a>
    {{$block->created_at}}
</article>
 <p>
 {!! $block->body !!}
 </p>
 <hr>
@endforeach
@endsection
