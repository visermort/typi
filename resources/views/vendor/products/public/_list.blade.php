<ul class="product-list-list">
    @foreach ($items as $product)
    @include('products::public._list-item')
    @endforeach
</ul>
