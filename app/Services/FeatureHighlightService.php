<?php

namespace App\Services;

use App\Http\Requests\StoreFeatureHighlightRequest;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FeatureHighlight;
use Illuminate\Http\JsonResponse;

class FeatureHighlightService
{
    /**
     * Retrieve the list of feature highlights.
     */
    public function getList(Request $request): JsonResponse
    {
        try {

            $columns = [
                0 => 'image',
                1 => 'title',
                2 => 'description', 
                3 => 'status',
                4 => 'actions',
            ];

            $featureHighlights = FeatureHighlight::query();
            $totalData = $featureHighlights->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if (empty($request->input('search.value'))) {
                $featureHighlights = $featureHighlights
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $featureHighlights = $featureHighlights
                    ->where('title', 'like', "%{$searchInput}%")
                    ->orWhere('description', 'like', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $featureHighlights->count();
            }

            $data = [];

            if (! empty($featureHighlights)) {
                foreach ($featureHighlights as $featureHighlight) {
                    $featureHighlightStatus = $featureHighlight->status ? __('app.enabled') : __('app.disabled');
                    $featureHighlightStatusClass = $featureHighlight->status ? 'success' : 'danger';
                    $status = "<button class='main-btn {$featureHighlightStatusClass}-btn-light btn-hover btn-sm' onclick=statusUpdate('{$featureHighlight->id}',this) style='padding:4px 10px' type='button'>{$featureHighlightStatus}</button>";

                    $image = '<img src="'.asset($featureHighlight->image).'" alt="'.$featureHighlight->title.'" class="img-fluid rounded" style="max-width: 100px">';
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');

                    $editLink = route('admin.feature-highlights.edit', $featureHighlight->id);
                    $editBtn = "<a href='{$editLink}' class='dropdown-item'>{$edit}</a>";
                    $detailBtn = "<button type='button' class='dropdown-item' data-bs-toggle='modal' data-bs-target='#detailsModal'
                    onclick='detailsModal({$featureHighlight})'>{$view}</button>";
                    $deleteBtn = "<button type='button' onclick=deleteFeatureHighlight('{$featureHighlight->id}',this.parentElement.parentElement)  class='dropdown-item'>{$delete}</button>";

                    $nestedData['image'] = $image; 
                    $nestedData['title'] = $featureHighlight->title;
                    $nestedData['description'] = $featureHighlight->description; 
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

            return success('Feature highlight  List', $json_data);

        } catch (\Exception $e) {
            logError('Feature highlight List Error', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeatureHighlightRequest $request): JsonResponse
    {
        try {
            
            $featureHighlight = new FeatureHighlight();
            $input = $request->except('_token');

            if ($request->has('image')) {
                if(!file_exists(public_path(FeatureHighlight::IMAGE_DIRECTORY))) {
                    mkdir(public_path(FeatureHighlight::IMAGE_DIRECTORY), 0755, true);
                }
                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = FeatureHighlight::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);
                $input['image'] = $url;
            }
            $featureHighlight->create($input);  
             
            return success(__('app.feature_highlight_created_successfully'), $featureHighlight);
        } catch (Exception $e) {
            logError('Feature Highlight Store Error', $e);
            return error(__('app.something_went_wrong'));
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update($request, FeatureHighlight $featureHighlight): JsonResponse
    {
        try {
            $input = $request->except('_token', '_method', 'image');
            $input['status'] = (bool) $request->status;

            if ($request->has('image') && $request->image != null && $request->image != '') {
                $oldImage = public_path($featureHighlight->image);
                if (file_exists($oldImage)) {
                    deleteImage($featureHighlight->image);
                }

                $image = $request->image;
                $filename = Str::slug($request->title).'-'.rand(1000, 9999).'.'.'webp';
                $url = FeatureHighlight::IMAGE_DIRECTORY.$filename;
                $location = public_path($url);
                saveImage($image, $location);

                $input['image'] = $url;
            }
 
            $featureHighlight->update($input);

            return success(__('app.feature_highlight_updated_successfully'), $featureHighlight);
        } catch (\Exception $e) {
            logError('Feature Highlight Update Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }
 
}
