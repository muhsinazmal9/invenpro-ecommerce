<?php

namespace App\Services;

use App\Http\Requests\StoreCmsPageRequest;
use App\Http\Requests\UpdateCmsPageRequest;
use App\Models\CmsPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CmsPageService
{
    public function create(StoreCmsPageRequest $request): JsonResponse
    {
        try {
            $input = request()->except('_token');

            $input['status'] = (bool) request()->status;
            $input['slug'] = generateSlug($request->title);

            $cmsPage = CmsPage::create($input);

            return success('Page created successfully!', $cmsPage);
        } catch (\Exception $e) {

            logError('CMS Page Store Error ', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateCmsPageRequest $request, CmsPage $page): JsonResponse
    {
        try {
            $input = $request->except('_token', '_method');

            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->title);

            $page->update($input);

            return success('Page updated successfully!', $page);
        } catch (\Exception $e) {
            logError('CMS Page Update Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {
        if (! checkUserPermission(CmsPage::LIST)) {
            return error('Permission Denied!', 403);
        }

        try {
            $columns = [
                0 => 'title',
                1 => 'content',
                2 => 'status',
                3 => 'created_at',
                4 => 'actions',
            ];

            $pages = CmsPage::query();

            $totalData = $pages->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $pages = $pages
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $pages = $pages
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
                $totalFiltered = $pages->count();
            }

            $data = [];

            if (! empty($pages)) {
                foreach ($pages as $page) {
                    // HTMLs

                    $editLink = route('admin.pages.edit', $page->slug);
                    $showLink = route('admin.pages.show', $page->slug);
                    $statusClass = $page->status ? 'success' : 'danger';
                    $pageStatus = $page->status ? 'Enabled' : 'Disabled';

                    $status = "<button onclick=statusUpdate('{$page->slug}',this) class='main-btn {$statusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px' type='button'>{$pageStatus}</button>";
                    $view = 'View';
                    $edit = 'Edit';
                    $delete = 'Delete';

                    $editBtn = "<a href='{$editLink}' class='dropdown-item' type='button'>{$edit}</a>";
                    $deleteBtn = "<button onclick=\"deletePage('{$page->slug}', this.parentElement.parentElement)\" class='dropdown-item'>
                                    {$delete}</button>";
                    $detailsBtn = "<a href='{$showLink}' class='dropdown-item'>{$view}</a>";

                    // DATAs
                    $nestedData['title'] = "<a class='text-black' href='{$editLink}'>{$page->title}</a>";
                    $nestedData['slug'] = $page->slug;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $page->created_at?->format('d/m/Y');
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

            return success('Page List', $json_data);
        } catch (\Exception $e) {
            logError('CMS Page List Error ', $e);

            return error('Something went wrong');
        }
    }
}
