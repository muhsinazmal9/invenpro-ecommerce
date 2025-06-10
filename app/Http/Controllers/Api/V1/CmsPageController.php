<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CmsPageResource;
use App\Models\CmsPage;
use Illuminate\Http\JsonResponse;

class CmsPageController extends Controller
{
    public function getCmsPage(): JsonResponse
    {
        $pages = CmsPage::where('status', CmsPage::STATUS['active'])->get();

        return success('Pages retrieved successfully', CmsPageResource::collection($pages));
    }

    public function cmsPageDetails(CmsPage $cmsPage): JsonResponse
    {
        return success('Page retrieved successfully', new CmsPageResource($cmsPage));
    }
}
