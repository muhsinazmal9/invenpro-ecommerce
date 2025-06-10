<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SubsubCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreSubsubCategoryRequest;
use App\Http\Requests\UpdateSubsubCategoryRequest;

class SubsubCategoryService
{
    public function create(StoreSubsubCategoryRequest $request): JsonResponse
    {
        try {

            $input = $request->except('_token', 'image');
            $input['slug'] = generateSlug($request->title);

            $input['status'] = (bool) $request->status;

            if ($request->has('image')) {
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = SubsubCategory::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $SubsubCategory = SubsubCategory::create($input);

            return success(__('app.subsubcategory_created_successfully'), $SubsubCategory);
        } catch (\Exception $e) {
            logError('Subsubcategory Store error:', $e);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {

        if (! checkUserPermission(SubsubCategory::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'title',
                1 => 'subcategory_id',
                2 => 'status',
                3 => 'created_at',
                4 => 'actions',
            ];

            $subsubcategories = SubsubCategory::query()->with('subcategory');
            $totalData = $subsubcategories->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'id';
            }

            if (empty($request->input('search.value'))) {
                $subsubcategories = $subsubcategories
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $subsubcategories = $subsubcategories
                    ->where('title', 'LIKE', "%{$searchInput}%")
                    ->orWhere(function ($query) use ($searchInput) {
                        if ($searchInput == 'enabled') {
                            $query->where('status', true);
                        }
                        if ($searchInput == 'disabled') {
                            $query->where('status', false);
                        }
                    })
                    ->orWhereHas('subcategory', function ($query) use ($searchInput) {
                        $query->where('title', 'LIKE', "%{$searchInput}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $subsubcategories->count();
            }

            $data = [];

            if (! empty($subsubcategories)) {
                foreach ($subsubcategories as $subsubcategory) {
                    /**
                     * HTMLs
                     */
                    $statusClass = $subsubcategory->status ? 'success' : 'danger';
                    $SubsubcategoryStatus = $subsubcategory->status ? __('app.enabled') : __('app.disabled');

                    $status = "<button type='button'' onclick=statusUpdate('{$subsubcategory->slug}',this) class='main-btn {$statusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px'>
                                    {$SubsubcategoryStatus}
                                </button>";

                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');

                    $editBtn = "<a href='".route('admin.subsub-category.edit', $subsubcategory->slug)."' class='dropdown-item' >{$edit}</a>";
                    $deleteBtn = "<button type='button' onclick=deleteSubsubCat('{$subsubcategory->slug}',this.parentElement.parentElement) class='dropdown-item' >{$delete}</button>";
                    $detailsBtn = "<button type='button' class='dropdown-item' data-bs-toggle='modal' data-bs-target='#detailsModal'
                    onclick='detailsModal($subsubcategory)'>{$view}</button>";

                    /**
                     * DATAs
                     */
                    $imagePath = !empty($subsubcategory->image) ? asset($subsubcategory->image) : getPlaceholderImage('200', '200');
                    $image = "<img class='rounded' src='{$imagePath}' alt='{$subsubcategory->title}' width='75'>";
                    $nestedData['title'] = $image . '&nbsp;&nbsp;&nbsp;' . $subsubcategory->title;
                    $nestedData['subcategory'] = $subsubcategory->subcategory?->title ?? '';
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $subsubcategory->created_at->format('d/m/y') ?? '';
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

            return success(__('app.subsubcategory_list'), $json_data);

        } catch (\Exception $e) {
            logError('Subcategory List Error ', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateSubsubCategoryRequest $request, SubsubCategory $subsubcategory): JsonResponse
    {
        try {
            $input = $request->except('_token', '_method', 'image');
            $input['slug'] = generateSlug($request->title);
            $input['status'] = (bool) $request->status;
            
            if ($request->has('image') && $request->image != null && $request->image != '') {
                $oldImage = public_path($subsubcategory->image);
                if (file_exists($oldImage)) {
                    deleteImage($subsubcategory->image);
                }
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = SubsubCategory::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $subsubcategory->update($input);

            return success(__('app.subsubcategory_updated_successfully'), $subsubcategory);
        } catch (\Exception $e) {
            info('Subsubcategory Update error:', [$e]);

            return error('Something went wrong');
        }
    }
}
