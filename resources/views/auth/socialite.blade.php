<div class="auth-container_socials">
    <div class="auth-container_socials-header">
        @lang('db.Use social networks')
    </div>
    <div class="auth-container_socials-items" >
        <div class="auth-container_socials-item auth-container_socials-item-facebook">
            <a class="btn btn-block btn-facebook" href="{{ action('\App\Http\Controllers\Auth\SocialController@login', 'facebook') }}">
                <i class="fa fa-facebook left"></i> Facebook
            </a>
        </div>
        <div class="auth-container_socials-item auth-container_socials-item-google">
            <a class="btn btn-block btn-google" href="{{ action('\App\Http\Controllers\Auth\SocialController@login', 'google') }}">
                <i class="fa fa-google left"></i> Google
            </a>
        </div>
        <div class="auth-container_socials-item auth-container_socials-item-vk">
            <a class="btn btn-block btn-vk" href="{{ action('\App\Http\Controllers\Auth\SocialController@login', 'vkontakte') }}">
                <i class="fa fa-vk left"></i> Vkontakte
            </a>
        </div>
    </div>
</div>
