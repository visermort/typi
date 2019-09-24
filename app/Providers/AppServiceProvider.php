<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\News\Models\News;
use App\Classes\Observers\TaggableObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        News::observe(TaggableObserver::class);
    }
}
