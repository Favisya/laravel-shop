@extends('layouts.layout')
@section('title', 'Главная')
@section('content')

    <h1>@lang('main.allProducts')</h1>
    <form method="GET" action=" {{ route('index') }}">
        <div class="filters row">
            <div class="col-sm-6 col-md-3">
                <label for="priceFrom">
                    @lang('main.priceFrom')
                    <input
                        type="text"
                        name="priceFrom"
                        id="priceFrom"
                        size="6"
                        value="{{ request()->priceFrom }}">
                </label>
                <label for="priceTo">
                    @lang('main.to')
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
                    @lang('main.properties.hit')
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
                    @lang('main.properties.new')
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
                    @lang('main.properties.recommend')
                </label>
            </div>
            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-primary">@lang('main.filter')</button>
                <a href="{{ route('index') }}" class="btn btn-warning">@lang('main.reset')</a>
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
