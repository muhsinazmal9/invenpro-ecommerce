<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DealResource;

class DealController extends Controller
{
    public function list(Request $request): JsonResponse
    {

        $deals = Deal::with('products')
            ->active()
            ->today()
            ->get();

        if (! $deals) {
            return notFound('No deals found.');
        }

        return success('Deals retrieved successfully.', DealResource::collection($deals));
    }

    public function details(Deal $deal): JsonResponse
    {

        $deal = $deal->active()
            ->today()
            ->firstOrFail();

        return success('Deal retrieved successfully.', new DealResource($deal));
    }
}
