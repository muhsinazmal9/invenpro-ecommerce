<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromoResource;
use App\Models\Promo;
use Illuminate\Http\JsonResponse;

class PromoController extends Controller
{
    public function list(): JsonResponse
    {

        $promos = Promo::where('status', Promo::STATUS['active'])
            ->where('limit', '>', 0)
            ->get();

        return success('promos retrieved', PromoResource::collection($promos));

    }

    public function detail($code): JsonResponse
    {
        $promo = Promo::where('code', $code)
            ->where('limit', '>', 0)
            ->where('status', Promo::STATUS['active'])->first();

        if (empty($promo)) {
            return error('This promo is not available at this moment', 404);
        }

        return success('promo retrieved', new PromoResource($promo));

    }
}
