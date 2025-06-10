<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\BannerTypeEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;

class BannerService
{
    public function create(StoreBannerRequest $request): JsonResponse
    {
        // dd($request->type);
        try {
            $input = $request->except('_token');



            if ($request->has('image')) {
                $image = $request->image;
                $filename = Str::slug($request->title) . '-' . rand(1000, 9999) . '.' . 'webp';
                $url = Banner::IMAGE_DIRECTORY . $filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $input['slug'] = generateSlug($request->title);
            $input['status'] = (bool) $request->status;
            if ($request->type == 'popup') {
                $input['type'] = 'popup';
            }


            $banner = Banner::create($input);

            return success(__('app.banner_created_successfully'), $banner);
        } catch (\Exception $e) {
            logError('Banner Store Error ', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateBannerRequest $request, Banner $banner): JsonResponse
    {
        try {
            $input = $request->except('_token', '_method', 'image');

            if ($banner->type == BannerTypeEnum::FIXED->value) {
                $input['status'] = true;
            } else {
                $input['status'] = (bool) $request->status;
                $input['slug'] = generateSlug($request->title);
            }

            if ($request->has('image') && $request->image != null && $request->image != '') {

                $oldImage = public_path($banner->image);

                if (file_exists($oldImage)) {
                    deleteImage($banner->image);
                }

                $image = $request->image;
                $filename = Str::slug($request->title) . '-' . rand(1000, 9999) . '.' . 'webp';
                $url = Banner::IMAGE_DIRECTORY . $filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }


            $banner->update($input);

            return success(__('app.banner_updated_successfully'), $banner);
        } catch (\Exception $e) {
            logError('Banner Update Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {
        if (!checkUserPermission('banner_list')) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'title',
                1 => 'status',
                2 => 'created_at',
                3 => 'actions',
            ];

            $banners = Banner::query()->whereNot('type', Banner::FIXED);

            $type = request('type');
            info($type);

            if ($type == 'popup') {

                $banners = $banners->where('type', 'popup');


            } else {
                $banners = $banners->where('type', '!=', 'popup');

            }

            $totalData = $banners->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'title';

            if ($order == 'actions') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $banners = $banners
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {

                $searchInput = $request->input('search.value');

                $banners = $banners
                    ->where('title', 'LIKE', "%{$searchInput}%")
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
                $totalFiltered = $banners->count();
            }

            $data = [];

            if (!empty($banners)) {
                foreach ($banners as $banner) {

                    $bannerStatus = $banner->status ? __('app.enabled') : __('app.disabled');
                    $statusClass = $banner->status ? 'success' : 'danger';
                    $editLink = route('admin.banner.edit', $banner->slug);
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');

                    $status = "<button class='main-btn {$statusClass}-btn-light btn-hover btn-sm' onclick=statusUpdate('{$banner->slug}',this) style='padding:4px 10px' type='button'>{$bannerStatus}</button>";
                    $detailsBtn = "<button type='button' class='dropdown-item' onclick='detailsModal({$banner})' data-bs-toggle='modal' data-bs-target='#detailsModal'>{$view}</button>";
                    $editBtn = "<a href='{$editLink}' class='dropdown-item'>{$edit}</a>";
                    $deleteBtn = "<button type='button' class='dropdown-item' onclick=deleteBanner('{$banner->slug}',this.parentElement.parentElement) class='dropdown-item'>{$delete}</a>";
                    $image_path = asset($banner->image);
                    $image = "<img src='{$image_path}' class='img-fluid rounded' style='width: 100px' />";

                    $nestedData['title'] = $image . '&nbsp;&nbsp;' . $banner->title;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $banner->created_at?->format('d-m-Y');
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        {$detailsBtn}
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

            return success(__('app.banner_list'), $json_data);
        } catch (\Exception $e) {
            logError('Banner List Error ', $e);

            return error('Something went wrong');
        }
    }
}
