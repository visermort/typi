{{--
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "",
    "name": "{{ $product->title }}",
    "description": "{{ $product->summary !== '' ? $product->summary : strip_tags($product->body) }}",
    "image": [
        "{{ $product->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $product->uri() }}"
    }
}
</script>
--}}
