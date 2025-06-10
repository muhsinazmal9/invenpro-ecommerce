<?php

namespace App\Http\Controllers;

use App\Enums\BannerTypeEnum;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Check if user has permission to access this controller
     */
    public function __construct(
        private BannerService $bannerService
    ) {
        $this->middleware('can:'.Banner::LIST)->only(['index', 'fixedBanners', 'getList']);
        $this->middleware('can:'.Banner::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Banner::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Banner::DELETE)->only(['destroy']);
        $this->middleware('can:'.Banner::STATUS_UPDATE)->only(['statusUpdate']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.banners.index');
    }

    public function fixedBanners(): View
    {
        return view('backend.banners.fixedBanners', [
            'banners' => Banner::where('type', BannerTypeEnum::FIXED)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request): RedirectResponse
    {
        $create = $this->bannerService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.banner.index')->with('success', $create->getData()->message);
        }

        return redirect()->back()->withInput()->with('error', $create->getData()->message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner): View
    {
        return view('backend.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner): RedirectResponse
    {
        $update = $this->bannerService->update($request, $banner);
        if ($update->getData()->success) {
            if ($banner->type == BannerTypeEnum::FIXED->value) {
                return redirect()->route('admin.banner.fixedBanners')->with('success', $update->getData()->message);
            }

            return redirect()->route('admin.banner.index')->with('success', $update->getData()->message);
        }

        return redirect()->back()->with('error', $update->getData()->message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner): JsonResponse
    {
        $banner->delete();

        return success(__('app.banner_deleted_successfully'));
    }

    public function getList(Request $request): JsonResponse
    {
        $banners = $this->bannerService->getList($request);

        if ($banners->getData()->success) {
            return response()->json($banners->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(Banner $banner): JsonResponse
    {
        $banner->status = ! $banner->status;
        $banner->save();

        return success(__('app.banner_status_update_successfully'), $banner);
    }
}
