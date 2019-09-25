@extends('pages::public.master')

@section('bodyClass', 'body-products body-products-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('products::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'products::public._list', ['items' => $models])

@endsection
