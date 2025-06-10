<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCmsPageRequest;
use App\Http\Requests\UpdateCmsPageRequest;
use App\Models\CmsPage;
use App\Services\CmsPageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CmsPageController extends Controller
{
    public function __construct(
        private CmsPageService $cmsPageService
    ) {
        // Check User Permissions
        $this->middleware('can:'.CmsPage::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.CmsPage::READ)->only('show');
        $this->middleware('can:'.CmsPage::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.CmsPage::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.CmsPage::DELETE)->only('destroy');
        $this->middleware('can:'.CmsPage::STATUS_UPDATE)->only('statusUpdate');

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.cms_pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.cms_pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCmsPageRequest $request): RedirectResponse
    {
        $create = $this->cmsPageService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.pages.index')->with('success', $create->getData()->message);
        }

        return back()->withInput()->with('error', $create->getData()->message);
    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $page): View
    {
        return view('backend.cms_pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CmsPage $page): View
    {
        return view('backend.cms_pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCmsPageRequest $request, CmsPage $page): RedirectResponse
    {
        $update = $this->cmsPageService->update($request, $page);

        if ($update->getData()->success) {
            return redirect()->route('admin.pages.index')->with('success', $update->getData()->message);
        }

        return back()->withInput()->with('error', $update->getData()->message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CmsPage $page): JsonResponse
    {
        $page->delete();

        return success(__('app.page_deleted_successfully'));
    }

    public function getList(Request $request): JsonResponse
    {
        $pages = $this->cmsPageService->getList($request);

        if ($pages->getData()->success) {
            return response()->json($pages->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(CmsPage $page): JsonResponse
    {
        $page->status = ! $page->status;
        $page->save();

        return success(__('app.banner_status_updated_successfully'), $page);

    }
}
