<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\FeatureHighlight;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureHighlightResource;

class FeatureHighlightController extends Controller
{
    public function __invoke()
    {
        $featureHighlights = FeatureHighlight::all();

        return success('Feature Highlights retrieved successfully', FeatureHighlightResource::collection($featureHighlights));
    }
}
