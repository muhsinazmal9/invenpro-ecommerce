<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Order;
use App\Models\Product;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function list(Request $request)//: JsonResponse
    {

        try {
            $limit = $request->limit ?? 20;
            $category_slug = $request->category;
            $subcategory_slug = $request->subcategory;
            $sub_subcategory_slug = $request->sub_subcategory;
            $brand_slug = $request->brand;
            $featured = $request->featured == '1' ? true : false;
            $new_arrival = $request->new_arrival == '1' ? true : false;
            $on_sale = $request->on_sale == '1' ? true : false;
            $campaign_slug = $request->campaign;
            // rating
            $rating = $request->rating;
            $queryParam = explode(',', $request->input('query'));
            $deal_slug = $request->deal_slug;

            $products = Product::query()->published()->with('brand', 'attributes', 'tags', 'images', 'reviews');

            // Sorting

            if (! empty($category_slug)) {
                $products = $products->whereHas('category', function ($query) use ($category_slug) {
                    $query->where('slug', $category_slug);
                });
            }

            if (! empty($subcategory_slug)) {
                $products = $products->whereHas('subcategory', function ($query) use ($subcategory_slug) {
                    $query->where('slug', $subcategory_slug);
                });
            }
            if (! empty($sub_subcategory_slug)) {
                $products = $products->whereHas('subsubCategory', function ($query) use ($sub_subcategory_slug) {
                    $query->where('slug', $sub_subcategory_slug);
                });
            }

            if (! empty($brand_slug)) {
                $products = $products->whereHas('brand', function ($query) use ($brand_slug) {
                    $query->where('slug', $brand_slug);
                });
            }

            if ($featured) {
                $products = $products->where('featured', true);
            }
            if ($new_arrival) {
                $products = $products->where('new_arrival', true);
            }
            if ($on_sale) {
                $products = $products->where('discount', '>', 0)->whereNotNull('discount_type');
            }

            if ($campaign_slug) {

                $campaign = Campaign::where('slug', $campaign_slug)->where('status', Campaign::STATUS['active'])
                    ->whereDate('start_date', '<=', now()->toDateString())
                    ->whereDate('end_date', '>=', now()->toDateString())
                    ->first();

                if (! $campaign) {
                    return error('Campaign not found', 404);
                }

                // campaign reject logic
                if ($campaign->start_date == now()->toDateString() && $campaign->start_time > now()->toTimeString()) {
                    return error('Campaign not started yet', 404);
                }

                if ($campaign->end_date == now()->toDateString() && $campaign->end_time <= now()->toTimeString()) {
                    return error('Campaign has been ended', 404);
                }

                $products = $products->where('discount', '<=', $campaign->discount)->where('discount_type', $campaign->discount_type);
            }

            if (in_array('top', $queryParam)) {
                $products = $products->whereHas('orders', function ($query) {
                    $query->where('order_status', Order::ORDER_STATUS['delivered']);
                })->orderBy('id', 'desc');
            }

            if (! empty($deal_slug)) {
                $products = $products->whereHas('deals', function ($query) use ($deal_slug) {
                    $query->where('slug', $deal_slug)
                        ->active()
                        ->whereDate('date', today()->toDateString());
                });
            }

            if ($rating) {
                $products->whereHas('reviews', function ($query) use ($rating) {
                    $query->select('product_id')
                    ->from('product_reviews')
                    ->selectRaw('ROUND(AVG(rating), 1) as avg_rating')
                    ->groupBy('product_id')
                    ->having('avg_rating', '=', $rating);
                });
            }



            $products = $products->paginate($limit);

            return paginator('Product retrieved successfully', ProductResource::collection($products));
        } catch (\Exception $e) {
            logError('Product List error | API ', $e);

            return error('Something went wrong');
        }

    }

    public function details(Product $product, Request $request): JsonResponse
    {
        if ($product->status !== Product::STATUS['published']) {
            return error('Product not found', 404);
        }

        $recentlyViewed = $request->session()->get('products.recently_viewed', []);

        $recentlyViewed = array_diff($recentlyViewed, [$product->id]);

        if (count($recentlyViewed) >= 3) {
            array_shift($recentlyViewed);
        }

        $recentlyViewed[] = $product->id;

        $request->session()->put('products.recently_viewed', $recentlyViewed);

        return success('Product retrieved successfully', new ProductResource($product));
    }

    public function recentlyViewed(): JsonResponse
    {
        $recentlyViewed = session()->get('products.recently_viewed', []);

        if (empty($recentlyViewed)) {
            return success('Recently Viewed Products', []);
        }

        $products = Product::published()
            ->whereIn('id', $recentlyViewed)
            ->get()
            ->sortByDesc(function ($product) use ($recentlyViewed) {
                return array_search($product->id, $recentlyViewed);
            });

        return success('Recently Viewed Products', ProductResource::collection($products));
    }
}
