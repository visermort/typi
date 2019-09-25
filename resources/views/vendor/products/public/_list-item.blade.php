<li class="product-list-item">
    <a class="product-list-item-link" href="{{ $product->uri() }}" title="{{ $product->title }}">
        <span class="product-list-item-title">{!! $product->title !!}</span>
        <span class="product-list-item-image-wrapper">
            <img class="product-list-item-image" src="{!! $product->present()->image(null, 200) !!}" alt="">
        </span>
    </a>
</li>
