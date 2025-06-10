<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\SubcategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function __construct(
        private SubcategoryService $subcategoryService
    ) {
        // Check User Permissions
        $this->middleware('can:'.Subcategory::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Subcategory::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Subcategory::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Subcategory::DELETE)->only('destroy');
        $this->middleware('can:'.Subcategory::STATUS_UPDATE)->only('statusUpdate');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.subcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::latest()->where('status', true)->get();

        return view('backend.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {

        $create = $this->subcategoryService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.subcategory.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message)->withInput();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory): View
    {
        $categories = Category::latest()->where('status', true)->get();

        return view('backend.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory): RedirectResponse
    {
        $update = $this->subcategoryService->update($request, $subcategory);

        if ($update->getData()->success) {
            return redirect()->route('admin.subcategory.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message)->withInput();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory): JsonResponse
    {

        $isError = false;
        $errorData = [];

        if ($subcategory->products?->count()) {
            $isError = true;
            $errorData[] = 'product';
        }

        if ($subcategory->category?->count()) {
            $isError = true;
            $errorData[] = 'category';
        }
        if ($subcategory->subsubCategories?->count()) {
            $isError = true;
            $errorData[] = 'sub subcategory';
        }

        if ($isError) {

            $message = 'this subcategory contains'.' '.implode(',', $errorData);

            return error($message);
        }

        $subcategory->delete();

        return success('Subcategory deleted successfully');
    }

    public function getList(Request $request): JsonResponse
    {
        $subcategories = $this->subcategoryService->getList($request);

        if ($subcategories->getData()->success) {
            return response()->json($subcategories->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(Subcategory $subcategory): JsonResponse
    {
        $subcategory->status = ! $subcategory->status;
        $subcategory->save();

        return success(__('app.subcategory_status_updated_successfully'), $subcategory);
    }
}
