@extends('core::admin.master')

@section('title', __('db.Enter E-mail'))
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

    <div id="login" class="container-login auth-container auth-container-sm">

        @include('users::_logo')

        {!! BootForm::open()->addClass('auth-container-form') !!}

        <h1 class="auth-container-title">{{ __('db.Enter E-mail') }}</h1>

        @include('users::_status')

        {!! BootForm::email(__('Email'), 'email')->addClass('form-control-lg')->autofocus(true)->required() !!}

        <div class="form-group">
            {!! BootForm::submit(__('db.Send'), 'btn-primary')->addClass('btn-lg btn-block') !!}
        </div>

        {!! BootForm::close() !!}

        <p class="auth-container-back-to-website">
            <a class="auth-container-back-to-website-link" href="{{ url('/') }}"><span class="fa fa-angle-left fa-fw"></span>{{ __('Back to the website') }}</a>
        </p>

    </div>

@endsection