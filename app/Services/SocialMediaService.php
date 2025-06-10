<?php

namespace App\Services;

use App\Http\Requests\StoreSocialMediaRequest;
use App\Http\Requests\UpdateSocialMediaRequest;
use App\Models\SocialMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialMediaService
{
    public function store(StoreSocialMediaRequest $request): JsonResponse
    {
        try {

            $socialMedia = SocialMedia::create([
                'platform_id' => $request->platform_id,
                'username' => $request->username,
                'status' => (bool) $request->status,
            ]);

            return success(__('app.social_media_added_successfully', $socialMedia->toArray()));

        } catch (\Exception $e) {
            logError('SocialMediaService@store', $e);

            return error('Something went wrong');
        }
    }

    public function Update(UpdateSocialMediaRequest $request, SocialMedia $social_medium): JsonResponse
    {
        try {
            $social_medium->update([
                'platform_id' => $request->platform_id,
                'username' => $request->username,
                'status' => (bool) $request->status,
            ]);

            return success(__('app.social_media_added_successfully', $social_medium->toArray()));

        } catch (\Exception $e) {
            logError('SocialMediaService@store', $e);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {
        if (! checkUserPermission(SocialMedia::SOCIAL_MEDIA_SETTINGS)) {
            return error('Permission Denied!', 403);
        }

        try {
            $columns = [
                0 => 'name',
                1 => 'icon',
                2 => 'url',
                3 => 'status',
                4 => 'created_at',
                5 => 'actions',
            ];

            $socialMedia = SocialMedia::query();

            $totalData = $socialMedia->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            // if order is by name, we need to order by platform_id

            if ($order == 'name' || $order == 'icon' || $order == 'url' || $order == 'actions') {
                $order = 'platform_id';
            }

            if (empty($request->input('search.value'))) {
                $socialMedia = $socialMedia
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                info('Search Input: ', [$searchInput]);

                $socialMedia = $socialMedia
                    ->where('username', 'LIKE', "%{$searchInput}%")
                    ->orWhere(function ($query) use ($searchInput) {

                        info('Search Input: ', [$searchInput]);

                        $platforms = collect(json_decode(file_get_contents(base_path('json/social_media.json'))));

                        // filter the platforms based on the search input
                        $platforms = $platforms->filter(function ($platform) use ($searchInput) {
                            return str_contains(strtolower($platform->name), strtolower($searchInput));
                        })->pluck('id');

                        $query->whereIn('platform_id', $platforms);
                    })
                    ->orWhere(function ($query) use ($searchInput) {

                        if ($searchInput == 'enabled') {
                            $query->where('status', true);
                        }

                        if ($searchInput == 'disabled') {
                            $query->where('status', false);
                        }
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $socialMedia->count();
            }

            $data = [];

            if (! empty($socialMedia)) {
                foreach ($socialMedia as $socialMedia) {

                    $socialStatus = $socialMedia->status ? 'Enabled' : 'Disabled';
                    $socialStatusClass = $socialMedia->status ? 'success' : 'danger';
                    $socialData = [
                        'id' => $socialMedia->id,
                        'platform_id' => $socialMedia->platform_id,
                        'username' => $socialMedia->username,
                        'status' => $socialMedia->status,
                    ];

                    $socialData = json_encode($socialData);

                    $status = "<button
                                onclick='socialStatusUpdate({$socialMedia->id},this)'
                                class='main-btn {$socialStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$socialStatus}</button>";
                    $view = 'View';
                    $edit = 'Edit';
                    $delete = 'Delete';

                    $editBtn = "<button data-bs-toggle='modal'  data='{$socialData}' data-bs-target='#editModal' class='dropdown-item social_edit_btn' >{$edit}</button>";
                    $deleteBtn = "<button type='button' class='dropdown-item' onclick=deleteSocial('.$socialMedia->id.',this.parentElement.parentElement) >{$delete}</button>";

                    // replace the :slug with the actual category slug

                    $nestedData['name'] = $socialMedia->platform?->name;
                    $nestedData['icon'] = "<i class='{$socialMedia->platform?->icon}'></i>";
                    $nestedData['url'] = "<a href='{$socialMedia->getFullUrl()}' target='_blank'>{$socialMedia->getFullUrl()}</a>";
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $socialMedia->created_at?->format('Y-m-d H:i:s');
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
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

            return success('Social Media List', $json_data);

        } catch (\Exception $e) {
            logError('Social Media List Error', $e);

            return error('Error getting settings');
        }

    }
}
