<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Products\Http\Requests\FormRequest;
use TypiCMS\Modules\Products\Models\Product;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('products::admin.index');
    }

    public function create(): View
    {
        $model = new Product();

        return view('products::admin.create')
            ->with(compact('model'));
    }

    public function edit(Product $product): View
    {
        return view('products::admin.edit')
            ->with(['model' => $product]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $product = Product::create($request->all());

        return $this->redirect($request, $product);
    }

    public function update(Product $product, FormRequest $request): RedirectResponse
    {
        $product->update($request->all());

        return $this->redirect($request, $product);
    }
}
