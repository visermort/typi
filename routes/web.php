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
            Route::prefix($locale)->any('/social_login/email-request', 'Auth\SocialController@emailRequest');
            Route::prefix($locale)->get('/social_login/email-verify', 'Auth\SocialController@emailVerify')->name('social.email-verify');
            Route::prefix($locale)->get('/social_login/email-send', 'Auth\SocialController@emailSend');
            Route::prefix($locale)->get('/social_login/{provider}', 'Auth\SocialController@login');
            Route::prefix($locale)->get('/social_login/callback/{provider}', 'Auth\SocialController@callback');
        } else {
            Route::any('/social_login/email-request', 'Auth\SocialController@emailRequest');
            Route::get('/social_login/email-verify', 'Auth\SocialController@emailVerify')->name('social.email-verify');
            Route::get('/social_login/email-send', 'Auth\SocialController@emailSend');
            Route::get('/social_login/{provider}', 'Auth\SocialController@login');
            Route::get('/social_login/callback/{provider}', 'Auth\SocialController@callback');
        }
    }

});
