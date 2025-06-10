<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {

        $subcategories = Subcategory::where('status', Subcategory::STATUS['active'])->get();

        return success('SubCategories retrieved successfully', SubcategoryResource::collection($subcategories));
    }

    public function details(Request $request, Subcategory $subcategory): JsonResponse
    {

        if ($subcategory->status === Subcategory::STATUS['inactive']) {
            return error('Subcategory is inactive', 404);
        }

        $request['schema'] = 'subsubcategories';

        return success('Subcategory details retrieved successfully', new SubcategoryResource($subcategory));
    }
}
