<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Products\Models\Product;
use Cache;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Product::published()->with('image')->get();

        return view('products::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        return Cache::get('product_by_slug_'.$slug, function () use ($slug) {
            $model = Product::published()->whereSlugIs($slug)->firstOrFail();

            return view('products::public.show')
                ->with(compact('model'));
        });
    }
}
