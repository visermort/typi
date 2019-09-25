<?php

namespace TypiCMS\Modules\Products\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Products\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('products')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = $page->private ? ['middleware' => 'auth'] : [];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-products');
                            $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::product');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('products', 'AdminController@index')->name('admin::index-products')->middleware('can:see-all-products');
                $router->get('products/create', 'AdminController@create')->name('admin::create-product')->middleware('can:create-product');
                $router->get('products/{product}/edit', 'AdminController@edit')->name('admin::edit-product')->middleware('can:update-product');
                $router->post('products', 'AdminController@store')->name('admin::store-product')->middleware('can:create-product');
                $router->put('products/{product}', 'AdminController@update')->name('admin::update-product')->middleware('can:update-product');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('products', 'ApiController@index')->middleware('can:see-all-products');
                    $router->patch('products/{product}', 'ApiController@updatePartial')->middleware('can:update-product');
                    $router->delete('products/{product}', 'ApiController@destroy')->middleware('can:delete-product');

                    $router->get('products/{product}/files', 'ApiController@files')->middleware('can:update-product');
                    $router->post('products/{product}/files', 'ApiController@attachFiles')->middleware('can:update-product');
                    $router->delete('products/{product}/files/{file}', 'ApiController@detachFile')->middleware('can:update-product');
                });
            });
        });
    }
}
