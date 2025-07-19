<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('frontend.category.index', compact('category'));
    }
}
