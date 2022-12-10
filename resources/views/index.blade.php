@extends('layouts.layout')
@section('title', 'Главная')
@section('content')

    <h1>Все товары</h1>
    <form method="GET" action=" {{ route('index') }}">
        <div class="filters row">
            <div class="col-sm-6 col-md-3">
                <label for="priceFrom">
                    Цена от
                    <input
                        type="text"
                        name="priceFrom"
                        id="priceFrom"
                        size="6"
                        value="{{ request()->priceFrom }}">
                </label>
                <label for="priceTo">
                    до
                    <input
                        type="text"
                        name="priceTo"
                        id="priceTo"
                        size="6"
                        value="{{ request()->priceTo }}">
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="hit">
                    <input
                        type="checkbox"
                        name="hit"
                        id="hit"
                        @if(request()->has('hit'))
                            checked
                        @endif
                    >
                    Хит
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="new">
                    <input
                        type="checkbox"
                        name="new"
                        id="new"
                        @if(request()->has('new'))
                            checked
                        @endif
                    >
                    Новинка
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="recommend">
                    <input
                        type="checkbox"
                        name="recommend"
                        id="recommend"
                        @if(request()->has('recommend'))
                            checked
                        @endif
                    >
                       Рекомендуем
                </label>
            </div>
            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-primary">Фильтр</button>
                <a href="{{ route('index') }}" class="btn btn-warning">Сброс</a>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach($products as $product)
            @include('layouts.card', compact('product'))
        @endforeach
    </div>
    {{ $products->links() }}
@endsection
