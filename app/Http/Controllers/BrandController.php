<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(
        private BrandService $brandService
    ) {
        $this->middleware('can:'.Brand::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Brand::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Brand::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Brand::DELETE)->only(['destroy']);
        $this->middleware('can:'.Brand::STATUS_UPDATE)->only(['statusUpdate']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $create = $this->brandService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.brand.index')->with('success', __('app.brand_created_successfully'));
        } else {
            return back()->with('error', __('app.something_went_wrong'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): View
    {
        return view('backend.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $update = $this->brandService->update($request, $brand);

        if ($update->getData()->success) {
            return redirect()->route('admin.brand.index')->with('success', $update->getData()->message);
        } else {
            return back()->with('error', __('app.something_went_wrong'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): JsonResponse
    {
        $isError = false;
        $errorData = [];

        if ($brand->products->count()) {
            $isError = true;
            $errorData[] = __('app.product');
        }

        if ($isError) {

            $message = __('app.this_brand_contains').' '.implode(',', $errorData);

            return error($message);
        }

        $brand->delete();

        return success(__('app.brand_deleted_successfully'));
    }

    /**
     * get list of brands
     */
    public function getList(Request $request): JsonResponse
    {
        $brands = $this->brandService->getList($request);

        if ($brands->getData()->success) {
            return response()->json($brands->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(Brand $brand): JsonResponse
    {
        $brand->status = ! $brand->status;
        $brand->save();

        return success(__('app.brand_status_updated_successfully'), $brand);
    }
}
