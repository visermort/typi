<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Arr;

/**
 * function not exists in laravel 6.xx, but uses in extension
 * @param $array
 * @param $key
 * @return mixed
 */
function array_get($array, $key)
{
    return Arr::get($array, $key);
}

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('reports', '\App\Http\Controllers\Admin\ReportsController@index');
    Route::get('reports/data', '\App\Http\Controllers\Admin\ReportsController@data');
});

Route::group(['middleware' => 'guest'], function () {
    foreach (locales() as $locale) {
        if (TypiCMS::mainLocale() !== $locale ||
            config('typicms.main_locale_in_url')
        ) {
            Route::prefix($locale)->any('/social_login/email-request', 'Auth\SocialController@emailRequest')
                ->name('social.email-request');
            Route::prefix($locale)->get('/social_login/email-verify', 'Auth\SocialController@emailVerify')
                ->name('social.email-verify')->middleware('signed');
            Route::prefix($locale)->get('/social_login/email-send', 'Auth\SocialController@emailSend')
                ->name('social.email-sent');
            Route::prefix($locale)->get('/social_login/{provider}', 'Auth\SocialController@login')
                ->name('social.login');
            Route::prefix($locale)->get('/social_login/callback/{provider}', 'Auth\SocialController@callback')
                ->name('social.callback');
        } else {
            Route::any('/social_login/email-request', 'Auth\SocialController@emailRequest')
                ->name('social.email-request');
            Route::get('/social_login/email-verify', 'Auth\SocialController@emailVerify')
                ->name('social.email-verify')->middleware('signed');
            Route::get('/social_login/email-send', 'Auth\SocialController@emailSend')
                ->name('social.email-sent');
            Route::get('/social_login/{provider}', 'Auth\SocialController@login')
                ->name('social.login');
            Route::get('/social_login/callback/{provider}', 'Auth\SocialController@callback')
                ->name('social.callback');
        }
    }

});
