@extends('core::public.master')

@section('title', $model->title.' – '.__('Products').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-products body-product-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Products', 'model' => $model])

    @include('products::public._json-ld', ['product' => $model])

    <article class="product">
        <h1 class="product-title">{{ $model->title }}</h1>
        <img class="product-image" src="{!! $model->present()->image(null, 200) !!}" alt="">
        <p class="product-summary">{!! nl2br($model->summary) !!}</p>
        <div class="product-body">{!! $model->present()->body !!}</div>
        @include('files::public._documents')
        @include('files::public._images')
        <div class="advantages">
            <h5>Advantages</h5>
            {!! MultiInput::publish('advantages', 'advantages', $model) !!}
        </div>

    </article>

@endsection
