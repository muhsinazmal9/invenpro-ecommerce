<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecentReviewResource;
use App\Http\Resources\ProductReviewResource;

class RecentReviewController extends Controller
{
    public function list()
    {
        $recentReviews = ProductReview::whereHas('product')->latest()->take(5)->get();

        return success('Recent reviews', RecentReviewResource::collection($recentReviews));
    }
}
