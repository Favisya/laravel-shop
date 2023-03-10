@extends('layouts.layout')
@section('title', 'корзина')
@section('content')
    <h1>Корзина</h1>
    <p>Оформление заказа</p>
    <div class="panel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>
                        <a href="{{route('product', [$product->category->code, $product->code])}}">
                            <img height="56px"
                                 src="{{ Storage::url($product->image) }}">
                            {{$product->name}}
                        </a>
                    </td>
                    <td><span class="badge">{{$product->pivot->count}}</span>
                        <div class="btn-group form-inline">
                            <form action="{{route('removeFromBasket', [$product->id])}}" method="POST">
                                <button type="submit" class="btn btn-danger" href="">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </button>
                                @csrf
                            </form>
                            <form action="{{route('addToBasket', [$product->id])}}" method="POST">
                                <button
                                    type="submit"
                                    class="btn btn-success"
                                    href=""
                                >
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                @csrf
                            </form>
                        </div>
                    </td>
                    <td>{{$product->price}} {{ App\Services\CurrencyOperations::getCurrencySymbol() }}</td>
                    <td>{{$product->getPriceForCount()}} {{ App\Services\CurrencyOperations::getCurrencySymbol() }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Общая стоимость:</td>
                <td>{{$order->calculatePrice()}} {{ App\Services\CurrencyOperations::getCurrencySymbol() }}</td>
            </tr>
            </tbody>
        </table>
        <br>
        @if ($order->calculatePrice() > 0)
            <div class="btn-group pull-right" role="group">
                <a type="button" class="btn btn-success" href="{{route('basketPlace')}}">Оформить заказ</a>
            </div>
        @endif
    </div>
@endsection
