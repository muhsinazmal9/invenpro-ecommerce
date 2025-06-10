<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Services\CampaignService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function __construct(private CampaignService $campaignService)
    {
        // Check User Permissions
        $this->middleware('can:'.Campaign::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Campaign::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Campaign::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Campaign::STATUS_UPDATE)->only('statusUpdate');

    }

    public function index(): View
    {
        return view('backend.campaign.index');
    }

    public function create(): View
    {
        return view('backend.campaign.create');
    }

    public function edit(Campaign $campaign): View
    {
        return view('backend.campaign.edit', compact('campaign'));
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {

        $create = $this->campaignService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.campaign.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message);

    }

    public function getList(Request $request): JsonResponse
    {
        $campaigns = $this->campaignService->getList($request);

        if ($campaigns->getData()->success) {
            return response()->json($campaigns->getData()->data);
        }

        return response()->json([]);

    }

    public function statusUpdate(Campaign $campaign): JsonResponse
    {
        $campaign->status = ! $campaign->status;
        $campaign->save();

        return success(__('app.campaign_status_updated_successfully'), $campaign);
    }

    public function destroy(Campaign $campaign): JsonResponse
    {
        $campaign->delete();

        return success('Campaign Deleted Successfully');
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $update = $this->campaignService->update($request, $campaign);
        if ($update->getData()->success) {
            return redirect()->route('admin.campaign.index')->with('success', $update->getdata()->message);
        }

        return back()->with('error', $update->getData()->message);

    }
}
