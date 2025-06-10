<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryService
{
    public function create(StoreCategoryRequest $request): JsonResponse
    {

        try {
            $category = new Category();
            $input = $request->except('_token');
            // dd($input);

            if ($request->has('image')) {
                $image = $request->image;
                $filename = Str::slug($request->name).'-'.rand(1000, 9999).'.'.'webp';
                $url = Category::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }

            $input['slug'] = generateSlug($request->name);

            $category->create($input);

            return success(__('app.category_created_successfully'), $category);

        } catch (\Exception $e) {
            logError('Category Store Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {

        try {
            $input = $request->except('_token', '_method', 'image');
            $input['status'] = (bool) $request->status;
            $input['show_in_quick_menu'] = (bool) $request->show_in_quick_menu;
            $input['show_in_home_page'] = (bool) $request->show_in_home_page;

            if ($request->has('image') && $request->image != null && $request->image != '') {
                $oldImage = public_path($category->image);
                if (file_exists($oldImage)) {
                    deleteImage($category->image);
                }

                $image = $request->image;
                $filename = Str::slug($request->name).'-'.rand(1000, 9999).'.'.'webp';
                $url = Category::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);

                $input['image'] = $url;
            }

            $input['slug'] = generateSlug($request->name);
            $category->update($input);

            return success(__('app.category_updated_successfully'), $category);
        } catch (\Exception $e) {
            logError('Category Update Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    public function getList(Request $request): JsonResponse
    {

        if (! checkUserPermission(Category::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'name',
                1 => 'status',
                2 => 'created_at',
                3 => 'actions',
            ];

            $categories = Category::query();

            $totalData = $categories->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'name';
            }

            if (empty($request->input('search.value'))) {
                $categories = $categories
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $categories = $categories
                    ->where('name', 'LIKE', "%{$searchInput}%")
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
                $totalFiltered = $categories->count();
            }

            $data = [];

            if (! empty($categories)) {
                foreach ($categories as $category) {

                    $editLink = route('admin.category.edit', $category->slug);

                    $categoryStatus = $category->status ? __('app.enabled') : __('app.disabled');
                    $categoryStatusClass = $category->status ? 'success' : 'danger';
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');


                    $status = "<button class='main-btn {$categoryStatusClass}-btn-light btn-hover btn-sm' onclick=statusUpdate('{$category->slug}',this) style='padding:4px 10px' type='button'>{$categoryStatus}</button>";
                    $editBtn = "<a href='{$editLink}' class='dropdown-item'>{$edit}</a>";
                    $deleteBtn = "<button type='button' onclick=deleteCategory('{$category->slug}') class='dropdown-item'>{$delete}</button>";

                    $detailBtn = "<button type='button'  data-bs-toggle='modal' data-bs-target='#detailsModal' class='dropdown-item'
                    onclick='detailsModal({$category})'>{$view}</button>";

                    $categoryImage = asset($category->image);
                    $image = "<img class='rounded' src='{$categoryImage}' alt='{$category->name}' width='75'>";
                    $name = "<a class='text-dark' href='".route('admin.category.edit', $category->slug)."'>".$image.'&nbsp;&nbsp;&nbsp;'.$category->name.'</a>';

                    $nestedData['name'] = $name;
                    $nestedData['status'] = $status;
                    $nestedData['show_in_quick_menu'] = $category->show_in_quick_menu ? '<div class="main-btn success-btn-light btn-hover btn-sm" style="padding:4px 10px" type="button">'.__('app.enabled').'</div>' : '<div class="main-btn danger-btn-light btn-hover btn-sm" style="padding:4px 10px" type="button">'.__('app.disabled').'</div>';
                    $nestedData['show_in_home_page'] = $category->show_in_home_page ? '<div class="main-btn success-btn-light btn-hover btn-sm" style="padding:4px 10px" type="button">'.__('app.enabled').'</div>' : '<div class="main-btn danger-btn-light btn-hover btn-sm" style="padding:4px 10px" type="button">'.__('app.disabled').'</div>';
                    $nestedData['created_at'] = $category->created_at?->format('d/m/y') ?? '';
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

            return success(__('app.category_list'), $json_data);
        } catch (\Exception $e) {
            logError('Category List Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }
}
