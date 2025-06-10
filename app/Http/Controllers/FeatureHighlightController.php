<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeatureHighlight;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\FeatureHighlightService;
use App\Http\Requests\StoreFeatureHighlightRequest;
use App\Http\Requests\UpdateFeatureHighlightRequest;

class FeatureHighlightController extends Controller
{
    public function __construct(private FeatureHighlightService $featureHighlightService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.feature_highlight.index');
    }

    /**
     * Fetch the list of feature highlights.
     */
    public function getList(Request $request): JsonResponse
    {
        $featureHighlights = $this->featureHighlightService->getList($request);

        if ($featureHighlights->getData()->success) {
            return response()->json($featureHighlights->getData()->data);
        }

        return response()->json(['Error']);

    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.feature_highlight.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeatureHighlightRequest $request): RedirectResponse
    { 
        $create = $this->featureHighlightService->store($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.feature-highlights.index')->with('success', $create->getData()->message);
        }

        return back()->withInput()->with('error', $create->getData()->message);
    }

    /**
     * Display the specified resource.
     */
    public function show(FeatureHighlight $featureHighlight): View
    {
        return view('backend.feature_highlight.show', compact('featureHighlight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeatureHighlight $featureHighlight): View
    {
        return view('backend.feature_highlight.edit', compact('featureHighlight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeatureHighlightRequest $request, FeatureHighlight $featureHighlight): RedirectResponse
    {
        $update = $this->featureHighlightService->update($request, $featureHighlight);

        if ($update->getData()->success) {
            return redirect()->route('admin.feature-highlights.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeatureHighlight $feature_highlight): JsonResponse
    {
         if ($feature_highlight->delete()) {
            return success(__('app.feature_highlight_deleted_successfully'));
        }

        return error(__('app.feature_highlight_deleted_error'));
    }

    public function statusUpdate(FeatureHighlight $feature_highlight) : JsonResponse
    {
        $feature_highlight->status = ! $feature_highlight->status;
        $feature_highlight->save();

        return success(__('app.feature_highlight_status_updated_successfully'), $feature_highlight);
    }

}
