<?php

namespace App\Services;

use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignService
{
    public function create(StoreCampaignRequest $request): JsonResponse
    {
        try {
            $campaign = new Campaign();
            $input = $request->except('_token');
            $input['status'] = (bool) $request->status;
            $input['slug'] = Str::slug($request->title);

            if ($request->has('image')) {
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = Campaign::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $campaign->create($input);

            return success(__('app.campaign_created_successfully'), $campaign);
        } catch (\Exception $e) {
            logError('Campaign Store Error ', $e);

            return error('Something went wrong');
        }

    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): JsonResponse
    {
        try {
            $input = $request->except('_token', '_method', 'image');
            $input['status'] = (bool) $request->status;
            $input['slug'] = Str::slug($request->title);

            if ($request->has('image') && $request->image != null && $request->image != '') {
                $oldImage = public_path($campaign->image);
                if (file_exists($oldImage)) {
                    deleteImage($campaign->image);
                }

                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = Campaign::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }
            $campaign->update($input);

            return success(__('app.campaign_update_successfully'), $campaign);

        } catch (\Exception $e) {
            logError('Campaign Update Error', $e);

            return error('Something went wrong');
        }

    }

    public function getList(Request $request): JsonResponse
    {

        try {

            $columns = [
                0 => 'title',
                1 => 'image',
                2 => 'discount',
                3 => 'discount_type',
                4 => 'start_date',
                5 => 'start_time',
                6 => 'end_date',
                7 => 'end_time',
                9 => 'status',
                10 => 'actions',
            ];

            $campaigns = Campaign::query();
            $totalData = $campaigns->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if (empty($request->input('search.value'))) {
                $campaigns = $campaigns
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $campaigns = $campaigns
                    ->where('title', 'like', "%{$searchInput}%")
                    ->orWhere('discount', 'like', "%{$searchInput}%")
                    ->orWhere('discount_type', 'like', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $campaigns->count();
            }

            $data = [];

            if (! empty($campaigns)) {
                foreach ($campaigns as $campaign) {
                    $campaignStatus = $campaign->status ? __('app.enabled') : __('app.disabled');
                    $campaignStatusClass = $campaign->status ? 'success' : 'danger';
                    $status = "<button class='main-btn {$campaignStatusClass}-btn-light btn-hover btn-sm' onclick=statusUpdate('{$campaign->id}',this) style='padding:4px 10px' type='button'>{$campaignStatus}</button>";

                    $image = '<img src="'.asset($campaign->image).'" alt="'.$campaign->title.'" class="img-fluid rounded" style="max-width: 100px">';
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');

                    $editLink = route('admin.campaign.edit', $campaign->id);
                    $editBtn = "<a href='{$editLink}' class='dropdown-item'>{$edit}</a>";
                    $detailBtn = "<button type='button' class='dropdown-item' data-bs-toggle='modal' data-bs-target='#detailsModal'
                    onclick='detailsModal({$campaign})'>{$view}</button>";
                    $deleteBtn = "<button type='button' onclick=deleteCampaign('{$campaign->id}',this.parentElement.parentElement)  class='dropdown-item'>{$delete}</button>";

                    $nestedData['title'] = $campaign->title;
                    $nestedData['image'] = $image;
                    $nestedData['discount'] = $campaign->discount;
                    $nestedData['discount_type'] = $campaign->discount_type;
                    $nestedData['start_date'] = $campaign->start_date;
                    $nestedData['start_time'] = $campaign->start_time;
                    $nestedData['end_date'] = $campaign->end_date;
                    $nestedData['end_time'] = $campaign->end_time;
                    $nestedData['status'] = $status;
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        {$detailBtn}
                        {$editBtn}
                        {$deleteBtn}
                    </div>
                  </div>";

                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('Product List', $json_data);

        } catch (\Exception $e) {
            logError('Product List Error', $e);

            return error('Something went wrong');
        }

    }
}
