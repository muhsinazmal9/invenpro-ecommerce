<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $type = $request->input('type');

        $banners = Banner::where('status', Banner::STATUS['active'])->orderBy('type', 'asc');

        if ($type) {
            $banners->where('type', $type);
        }

        $banners = $banners->get();

        return success('banners retrieved', BannerResource::collection($banners));
    }
}
