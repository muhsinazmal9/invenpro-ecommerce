<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\CampaignService;

class CampaignController extends Controller
{
    public function __construct(
        private CampaignService $campaignService,
    ) {

    }

    public function __invoke()
    {

        $campaigns = Campaign::where('status', Campaign::STATUS['active'])
            ->whereDate('start_date', '<=', now()->toDateString())
            ->whereDate('end_date', '>=', now()->toDateString())
            ->get();

        // campaign reject logic
        $campaigns = $campaigns->reject(function ($campaign) {
            if ($campaign->start_date == now()->toDateString() && $campaign->start_time > now()->toTimeString()) {
                return true;
            }
            if ($campaign->end_date == now()->toDateString() && $campaign->end_time <= now()->toTimeString()) {
                return true;
            }

            return false;
        });

        return success('Campaigns retrieved successfully.', CampaignResource::collection($campaigns));
    }
}
