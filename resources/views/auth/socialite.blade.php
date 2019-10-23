<div class="auth-container_socials">
    <div class="auth-container_socials-header">
        @lang('Use social networks')
    </div>
    <div class="auth-container_socials-items" >
        @foreach (config('services') as $socialName => $social)
            @if (!empty($social['registration']))
                <div class="auth-container_socials-item auth-container_socials-item-facebook">
                    <a class="btn btn-block btn-facebook" href="{{ route('social.login', $socialName) }}">
                        {!! $social['title'] !!}
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</div>
