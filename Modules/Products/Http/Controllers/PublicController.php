<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Products\Models\Product;

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
        $model = Product::published()->whereSlugIs($slug)->firstOrFail();

        return view('products::public.show')
            ->with(compact('model'));
    }
}
