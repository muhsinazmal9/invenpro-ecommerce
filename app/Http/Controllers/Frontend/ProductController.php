<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $products = Product::where('category_id', $category->id)->get();
        return view('frontend.category.index', compact('category', 'products'));
    }
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->first();
        return view('frontend.product.index', compact('product'));
    }
}
