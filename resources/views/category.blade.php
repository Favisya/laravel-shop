@extends('layouts.layout')
@section('title', $category->name)
@section('content')
    <h1>
        {{$category->__('name')}} - товаров: {{$category->products->count()}}
    </h1>
    <p>
        {{$category->__('description')}}
    </p>
    <div class="row">
        @foreach($category->products()->with('category')->get() as $product)
            @include('layouts.card', compact('product'))
        @endforeach
    </div>
@endsection
