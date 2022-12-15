<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            @if($product->isNew())
                <span class="badge badge-success">@lang('main.properties.new')</span>
            @endif

            @if($product->isRecommend())
                <span class="badge badge-warning">@lang('main.properties.recommend')</span>
            @endif

            @if($product->isHit())
                <span class="badge badge-danger">@lang('main.properties.hit')</span>
            @endif
        </div>
        <div class="labels">
        </div>
        <img src="{{ Storage::url($product->image) }}" alt="iPhone X 64GB">
        <div class="caption">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->price }} ₽</p>
            <p>
            <form action="{{ route('addToBasket', $product) }}" method="POST">
                @if($product->isAvailable())
                <button type="submit" class="btn btn-primary" role="button">@lang('main.toCart')</button>
                @else
                    @lang('main.notAvailable')
                @endif
                <a href="{{ route('product', [
                                isset($category) ? $category->code : $product->category->code,
                                $product->code,
                         ])}}"
                   class="btn btn-default"
                   role="button">
                    @lang('main.more')
                </a>
                @csrf
            </form>
            </p>
        </div>
    </div>
</div>
