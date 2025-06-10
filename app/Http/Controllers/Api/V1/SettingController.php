<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function __invoke(): JsonResponse
    {

        // $settings = Settings::whereNotIn('key', ['google_places_api_key'])->get();

        $settings = Settings::whereNotIn('key', [
            'stripe_publishable_key',
            'stripe_secret_key',
            'stripe_status'
        ])->get();

        return success('Settings retrieved successfully.', SettingResource::collection($settings));
    }
}
