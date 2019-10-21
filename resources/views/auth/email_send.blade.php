@extends('core::admin.master')

@section('title', __('Verify'))
@section('bodyClass', 'auth-background')

@section('page-header')
@endsection
@section('sidebar')
@endsection
@section('mainClass')
@endsection
@section('errors')
@endsection

@section('content')

<div id="verify" class="container-verify auth-container">

    @include('users::_logo')

    <div class="auth-container-form">

        <h1 class="auth-container-title">{{ __('Verify Your Email Address') }}</h1>

            @if (session('send'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <a class="" href="{{ url('/') }}">@lang('Main')</a>

        </div>

    </div>

</div>

@endsection
