<?php

namespace App\Services;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandService
{
    public function create(StoreBrandRequest $request): JsonResponse
    {
        try {
            $input = $request->except('_token');

            if ($request->has('image')) {
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.webp';
                $url = Brand::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->title);

            $brand = Brand::create($input);

            return success(__('app.brand_created_successfully'), $brand);
        } catch (\Exception $e) {
            logError('Brand Store Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        try {
            $input = $request->except('_token', '_method');

            if ($request->has('image')) {
                // Delete old image if exists
                if ($brand->image) {
                    deleteImage(public_path($brand->image));
                }
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.webp';
                $url = Brand::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->title);

            $brand->update($input);

            return success(__('app.brand_updated_successfully'), $brand);
        } catch (\Exception $e) {
            logError('Brand Update Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    public function getList(Request $request): JsonResponse
    {
        if (! checkUserPermission(Brand::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'title',
                1 => 'status',
                2 => 'created_at',
                3 => 'actions',
            ];

            $brands = Brand::query();

            $totalData = $brands->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $brands = $brands
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $brands = $brands
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
                $totalFiltered = $brands->count();
            }

            $data = [];

            if (! empty($brands)) {
                foreach ($brands as $brand) {
                    // HTMLs

                    $editLink = route('admin.brand.edit', $brand->slug);
                    $statusClass = $brand->status ? 'success' : 'danger';
                    $brandStatus = $brand->status ? 'Enabled' : 'Disabled';

                    $status = "<button class='main-btn {$statusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px' type='button' onclick=statusUpdate('{$brand->slug}',this)>{$brandStatus}</button>";
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');

                    $editBtn = "<a href='{$editLink}'  type='button' class='dropdown-item'>{$edit}</a>";
                    $deleteBtn = "<button onclick=\"deleteBrand('{$brand->slug}', this.parentElement.parentElement)\" class='dropdown-item'>
                                        {$delete}
                                    </button>";
                    $detailsBtn = "<button onclick='detailsModal({$brand})' data-bs-toggle='modal' data-bs-target='#detailsModal' class='dropdown-item'>{$view}</button>";

                    $image = !empty($brand->image) ? "<img class='rounded' src='{$brand->image}' alt='{$brand->title}' width='75'>" : "<img class='rounded' src=". getPlaceholderImage('160','100') ." alt='{$brand->title}' width='75'>";
                    $nestedData['title'] = $image . '&nbsp;&nbsp;&nbsp;' . $brand->title;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $brand->created_at?->format('d/m/Y');
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

            return success(__('app.brand_list'), $json_data);
        } catch (\Exception $e) {
            logError('Brand List Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }
}
