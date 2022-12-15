@extends('layouts.layout')
@section('title', 'Товар')
@section('content')
    <h1>{{$product->name}}</h1>
    <h2>{{$product->category->name}}</h2>
    <p>Цена: <b>{{$product->price}} ₽</b></p>
    <img src="{{ Storage::url($product->image) }}">
    <p>{{$product->description}}</p>


        @if($product->isAvailable())
            <form action="{{route('addToBasket', $product)}}" method="POST">
                <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
                @csrf
            </form>
        @else
            <span>в данный момент не доступен</span>
            <br>
            @include('auth.layouts.error', ['field' => 'email'])
            <form  method="POST" action="{{ route('subscription', $product) }}" >
                <input type="text" name="email">
                <button type="submit">
                    Подписаться на товар
                </button>
                @csrf
            </form>
        @endif

@endsection
