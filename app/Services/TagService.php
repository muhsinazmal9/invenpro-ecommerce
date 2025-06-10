<?php

namespace App\Services;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagService
{
    public function create(StoreTagRequest $request): JsonResponse
    {
        try {
            $input = $request->except('_token');
            $input['slug'] = generateSlug($request->title);
            $input['status'] = (bool) $request->status;
            $tags = Tag::create($input);

            return success(__('app.tag_created_successfully'), $tags);
        } catch (\Exception $e) {
            logError('tags Store Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    public function getList(Request $request): JsonResponse
    {

        if (! checkUserPermission(Tag::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'title',
                1 => 'status',
                2 => 'actions',
            ];

            $tags = Tag::query();

            $totalData = $tags->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order = 'actions') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $tags = $tags
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            } else {
                $searchInput = $request->input('search.value');

                $tags = $tags
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
                $totalFiltered = $tags->count();
            }

            $data = [];

            if (! empty($tags)) {
                foreach ($tags as $tag) {

                    $tagStatus = $tag->status ? __('app.enabled') : __('app.disabled');
                    $tagStatusClass = $tag->status ? 'success' : 'danger';
                    $slug = $tag->slug;

                    $status = "<button
                                onclick=tagsStatusUpdate('{$slug}',this)
                                class='main-btn {$tagStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$tagStatus}
                                </button>";
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');


                    $editBtn = "<a
                                href='".route('admin.tags.edit', $tag->slug)."'
                                    class='dropdown-item'>
                                    {$edit}
                                </a>";

                    $deleteBtn = "<button
                                        type='button'
                                        onclick=deletetags(':slug',this.parentElement.parentElement)
                                        class='dropdown-item'>
                                        {$delete}
                                    </button>";

                    // replace the :slug with the actual tags slug
                    $deleteBtn = str_replace(':slug', $tag->slug, $deleteBtn);

                    $detailBtn = "<button
                                    type='button'
                                    class='dropdown-item'
                                    data-bs-toggle='modal'
                                    data-bs-target='#detailsModal'
                                    onclick='detailsModal({$tag})'>
                                    {$view}
                                </button>";

                    $nestedData['title'] = $tag->title;
                    $nestedData['status'] = $status;
                    $nestedData['actions'] ="<div class='dropdown text-center'>
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

            return success(__('app.tag_list'), $json_data);
        } catch (\Exception $e) {
            logError('tags List Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    public function update(UpdateTagRequest $request, Tag $tags): JsonResponse
    {

        try {
            $input = $request->except('_token', '_method');
            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->title);
            $tags->update($input);

            return success(__('app.tag_updated_successfully'), $tags);
        } catch (\Exception $e) {
            logError('Tags Update Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }
}
