<?php

namespace App\Services;

use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryService
{
    public function create(StoreSubcategoryRequest $request): JsonResponse
    {
        try {

            $input = $request->except('_token');
            $input['slug'] = generateSlug($request->title);

            $input['status'] = (bool) $request->status;

            if ($request->has('image')) {
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = Subcategory::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $subcategory = Subcategory::create($input);

            return success('Subcategory created successfully', $subcategory);
        } catch (\Exception $e) {
            logError('Subcategory Store error:', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory): JsonResponse
    {

        try {
            $input = $request->except('_token', '_method', 'image');
            $input['slug'] = generateSlug($request->title);
            $input['status'] = (bool) $request->status;

            if ($request->has('image') && $request->image != null && $request->image != '') {
                $oldImage = public_path($subcategory->image);
                if (file_exists($oldImage)) {
                    deleteImage($subcategory->image);
                }
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = Subcategory::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $subcategory->update($input);

            return success('Subcategory updated successfully', $subcategory);
        } catch (\Exception $e) {
            info('Subcategory Update error:', [$e]);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {

        if (! checkUserPermission(Subcategory::LIST)) {
            return error('Permission Denied!', 403);
        }

        try {
            $columns = [
                0 => 'title',
                1 => 'category_id',
                2 => 'status',
                3 => 'created_at',
                4 => 'actions',
            ];

            $subcategories = Subcategory::query()->with('category');
            $totalData = $subcategories->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'id';
            }

            if (empty($request->input('search.value'))) {
                $subcategories = $subcategories
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $subcategories = $subcategories
                    ->where('title', 'LIKE', "%{$searchInput}%")
                    ->orWhere(function ($query) use ($searchInput) {
                        if ($searchInput == 'enabled') {
                            $query->where('status', true);
                        }
                        if ($searchInput == 'disabled') {
                            $query->where('status', false);
                        }
                    })
                    ->orWhereHas('category', function ($query) use ($searchInput) {
                        $query->where('name', 'LIKE', "%{$searchInput}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $subcategories->count();
            }

            $data = [];

            if (! empty($subcategories)) {
                foreach ($subcategories as $subcategory) {
                    /**
                     * HTMLs
                     */
                    $statusClass = $subcategory->status ? 'success' : 'danger';
                    $SubCategoryStatus = $subcategory->status ? 'Enabled' : 'Disabled';

                    $status = "<button type='button'' onclick=statusUpdate('{$subcategory->slug}',this) class='main-btn {$statusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px'>
                                    {$SubCategoryStatus}
                                </button>";
                    $view = 'View';
                    $edit = 'Edit';
                    $delete = 'Delete';

                    $editBtn = "<a href='".route('admin.subcategory.edit', $subcategory->slug)."'  class='dropdown-item'>{$edit}</a>";
                    $deleteBtn = "<button type='button' onclick=deleteSubCat('{$subcategory->slug}',this.parentElement.parentElement)  class='dropdown-item'>{$delete}</button>";

                    $detailsBtn = "<button type='button' data-bs-toggle='modal' data-bs-target='#detailsModal' class='dropdown-item'
                    onclick='detailsModal($subcategory)'>{$view}</button>";

                    $subcategoryImage = asset($subcategory->image);
                    $image = "<img class='rounded' src='{$subcategoryImage}' alt='{$subcategory->name}' width='75'>";

                    $title = "<a class='text-dark' href='".route('admin.subcategory.edit', $subcategory->slug)."'>".$image.'&nbsp;&nbsp;&nbsp;'.$subcategory->title.'</a>';

                    /**
                     * DATAs
                     */
                    $nestedData['title'] = $title;
                    $nestedData['category'] = $subcategory->category->name ?? '';
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $subcategory->created_at->format('d/m/y') ?? '';
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

            return success('Subcategory List', $json_data);
        } catch (\Exception $e) {
            logError('Subcategory List Error ', $e);

            return error('Something went wrong');
        }
    }
}
