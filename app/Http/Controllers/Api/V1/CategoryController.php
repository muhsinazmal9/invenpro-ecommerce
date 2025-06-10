<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Order;
use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $showInQuickMenu = $request->input('show_in_quick_menu', false);
        $showInHomePage = $request->input('show_in_home_page', false);

        $categories = Category::query()
            ->where('status', Category::STATUS['active']);

        if ($showInQuickMenu) {
            $categories->where('show_in_quick_menu', true);
        }

        if ($showInHomePage) {
            $categories->where('show_in_home_page', true);
        }

        if ($query) {
            $categories = $categories->whereHas('products', function ($query) {
                $query->whereHas('orders', function ($query) {
                    $query->where('order_status', Order::ORDER_STATUS['delivered']);
                });
            })->latest()->take(5);
        }

        $categories = $categories->get();

        return success('Categories retrieved successfully', CategoryResource::collection($categories));
    }

    public function details(Request $request, Category $category): JsonResponse
    {
        $request['schema'] = Category::SUBCATEGORIES . ',' . Subcategory::SUBSUBCATEGORIES . ',' . Category::BRANDS . ',' . Category::RATINGS;

        if ($category->status === Category::STATUS['inactive']) {
            return error('Category is inactive', 404);
        }

        return success('Category details retrieved successfully', new CategoryResource($category));
    }
}
