@extends ('layout')
@section('content')
 @foreach ($blocks as $block)
<article>
    {{$block->title}}
    {{$block->created_at}}
</article>
 <p>
 {!! $block->body !!}
 </p>
     <hr>
@endforeach
@endsection
