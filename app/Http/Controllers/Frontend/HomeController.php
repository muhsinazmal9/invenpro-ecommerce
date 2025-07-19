<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::where('show_in_home_page', true)->get();
        
        return view('frontend.home.index', compact('categories'));
    }
}
