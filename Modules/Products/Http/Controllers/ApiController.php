<?php

namespace TypiCMS\Modules\Products\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Products\Models\Product;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Product::class)
            ->selectFields($request->input('fields.products'))
            ->allowedSorts(['status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Product $product, Request $request): JsonResponse
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $product->$key = $value;
        }
        $saved = $product->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $deleted = $product->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Product $product): Collection
    {
        return $product->files;
    }

    public function attachFiles(Product $product, Request $request): JsonResponse
    {
        return $product->attachFiles($request);
    }

    public function detachFile(Product $product, File $file): void
    {
        $product->detachFile($file);
    }
}
