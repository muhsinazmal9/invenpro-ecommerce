<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubsubCategoryRequest;
use App\Http\Requests\UpdateSubsubCategoryRequest;
use App\Models\Subcategory;
use App\Models\SubsubCategory;
use App\Services\SubsubCategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubsubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private SubsubCategoryService $SubsubCategoryService

    ) {
        // Check User Permissions
        $this->middleware('can:'.SubsubCategory::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.SubsubCategory::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.SubsubCategory::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.SubsubCategory::DELETE)->only('destroy');
        $this->middleware('can:'.SubsubCategory::STATUS_UPDATE)->only('statusUpdate');
    }

    public function index()
    {
        return view('backend.sub_subcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = Subcategory::orderBy('title', 'asc')->where('status', Subcategory::STATUS['active'])->get();

        return view('backend.sub_subcategories.create', compact('subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubsubCategoryRequest $request): RedirectResponse
    {

        $create = $this->SubsubCategoryService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.subsub-category.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message)->withInput();

    }

    /**
     * Display the specified resource.
     */
    public function show(SubsubCategory $SubsubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubsubCategory $SubsubCategory): View
    {
        $subcategories = Subcategory::orderBy('title', 'asc')->where('status', Subcategory::STATUS['active'])->get();

        return view('backend.sub_subcategories.edit', compact('subcategories', 'SubsubCategory'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubsubCategoryRequest $request, SubsubCategory $subsub_category)
    {

        $update = $this->SubsubCategoryService->update($request, $subsub_category);

        if ($update->getData()->success) {
            return redirect()->route('admin.subsub-category.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message)->withInput();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubsubCategory $SubsubCategory)
    {
        $isError = false;
        $errorData = [];

        if ($SubsubCategory->products?->count()) {
            $isError = true;
            $errorData[] = 'product';
        }
        if ($SubsubCategory->subsubCategories?->count()) {
            $isError = true;
            $errorData[] = 'subcategory';
        }

        if ($isError) {

            $message = 'this sub subcategory contains'.' '.implode(',', $errorData);

            return error($message);
        }

        $SubsubCategory->delete();

        return success('Subsubcategory Deleted Successfully');

    }

    public function getList(Request $request): JsonResponse
    {
        $subsubcategories = $this->SubsubCategoryService->getList($request);

        if ($subsubcategories->getData()->success) {
            return response()->json($subsubcategories->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(SubsubCategory $subsubcategory): JsonResponse
    {
        $subsubcategory->status = ! $subsubcategory->status;
        $subsubcategory->save();

        return success(__('app.subcategory_status_updated_successfully'), $subsubcategory);
    }
}
