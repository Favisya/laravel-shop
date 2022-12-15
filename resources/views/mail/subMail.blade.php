Уважаемый пользователь, Товар {{ $product->name }} снова появился у нас.

<a href="{{ route('product', [$product->category->code, $product->code]) }}">
    Подробнее
</a>
