<?php

namespace App\Http\Controllers\Api\V1;
 
use Illuminate\Http\Request; 
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource; 

class WishlistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $limit = $request->query('limit', 20);
    
        $wishlists = $user->wishlists()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->whereHas('product', function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->search}%")
                        ->orWhere('slug', 'like', "%{$request->search}%")
                        ->orWhere('price', 'like', "%{$request->search}%")
                        ->orWhere('sku', 'like', "%{$request->search}%")
                        ->orWhere('short_description', 'like', "%{$request->search}%")
                        ->orWhereHas('category', function ($query) use ($request) {
                            $query->where('title', 'like', "%{$request->search}%");
                        }); 
                });
            })
            ->paginate($limit);

        if ($wishlists->isEmpty()) {
            return error('Wishlists not found', 404);
        }

        return paginator('Wishlists retrieved successfully', WishlistResource::collection($wishlists));
    }
    

    public function store(Request $request): JsonResponse
    {
       $requestData =  $request->validate([
           'product_id' => 'required|integer|exists:products,id',
        ]);
        $requestData['user_id'] = auth()->user()->id;
         
        $exists = auth()->user()->wishlists()
        ->where('product_id', $requestData['product_id'])
        ->exists();

        if ($exists) {
            return error('Product already exists in wishlist', 409);
        }

        $data = auth()->user()->wishlists()->create($requestData);
        return success('Wishlist added successfully', new WishlistResource($data));
    }


    public function destroy(int $product_id): JsonResponse
    {
        $user = auth()->user();
     
        $wishlist = $user->wishlists()->where('product_id', $product_id)->first();
    
        if (!$wishlist) {
            return error('Product not found in wishlist', 404);
        }
    
        $wishlist->delete();
    
        return success('Wishlist deleted successfully', new WishlistResource($wishlist));
    }
    
}
