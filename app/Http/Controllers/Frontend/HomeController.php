<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::where('show_in_home_page', true)->get();
        $brands = Brand::take(6)->get();
        
        return view('frontend.home.index', compact('categories', 'brands'));
    }
}
