@extends('core::admin.master')

@section('title', __('New product'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'products'])
        <h1 class="header-title">@lang('New product')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-products'))->multipart()->role('form') !!}
        @include('products::admin._form')
    {!! BootForm::close() !!}

@endsection
