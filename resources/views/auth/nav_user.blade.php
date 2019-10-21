@if (Auth::user() == null)
    <a href="{{ route(TypiCMS::mainLocale().'::login') }}">@lang('Login')</a>
    <a href="{{ route(TypiCMS::mainLocale().'::register') }}">@lang('Register')</a>
@else
    @if (Auth::user()->getAvatar())
        <img src="{{ Auth::user()->getAvatar() }}" style="max-width: 40px;" alt="User Logo">
    @endif
    <form action="{{ route(TypiCMS::mainLocale().'::logout') }}" method="post">
        {{ csrf_field() }}
        <input class="btn btn-secondary btn-sm" type="submit" value="@lang('Logout')"/>
    </form>
@endif