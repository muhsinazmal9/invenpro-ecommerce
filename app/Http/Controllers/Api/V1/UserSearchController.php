<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserSearchController extends Controller
{
    public function productSearches(Request $request)
    {

        $keywordInput = $request->keyword;

        if (empty($keywordInput)) {
            return error('Keyword input is required', 404);
        }

        $products = $this->getProduct($keywordInput);

        $isAdminRequest = (bool) $request->input('is_admin');
        if (! $isAdminRequest) {
            $this->keywordStore($keywordInput);
        }

        return success('Product searches retrieved', ProductResource::collection($products));
    }

    private function keywordStore(string $keywordInput): void
    {
        $userSearch = UserSearch::firstOrCreate([
            'keyword' => $keywordInput,
        ]);
        $userSearch->increment('count');
    }

    public function getPopularSearches()
    {
        $popularSearches = UserSearch::orderByDesc('count')->take(10)->pluck('keyword');

        $data = [];
        foreach ($popularSearches as $search) {
            $productIds = Product::where(function ($query) {
                $query->published();
            })
                ->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%")
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('brand', function ($query) use ($search) {
                            $query->where('title', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('subcategory', function ($query) use ($search) {
                            $query->where('title', 'LIKE', "%{$search}%");
                        });
                })
                ->pluck('id');

            if (count($productIds)) {
                $data[] = $productIds;
            }
        }

        $data = array_unique(Arr::flatten($data));
        $productsByCategory = ProductResource::collection(Product::whereIn('id', $data)->get());

        return success('Popular searches retrieved', $productsByCategory->groupBy('category.name'));
    }

    private function getProduct(string $keywordInput)
    {
        $products = Product::published()
            ->where(function ($query) use ($keywordInput) {
                $query->where('title', 'LIKE', "%{$keywordInput}%")
                    ->orWhereHas('category', function ($query) use ($keywordInput) {
                        $query->where('name', 'LIKE', "%{$keywordInput}%");
                    })
                    ->orWhereHas('brand', function ($query) use ($keywordInput) {
                        $query->where('title', 'LIKE', "%{$keywordInput}%");
                    })
                    ->orWhereHas('subcategory', function ($query) use ($keywordInput) {
                        $query->where('title', 'LIKE', "%{$keywordInput}%");
                    });
            })
            ->get();
        return $products;
    }
}
