<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
        // Check User Permissions
        $this->middleware('can:'.Category::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Category::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Category::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Category::DELETE)->only('destroy');
        $this->middleware('can:'.Category::STATUS_UPDATE)->only('statusUpdate');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() //: View
    {
        return view('backend.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {

        $create = $this->categoryService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.category.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {

        $update = $this->categoryService->update($request, $category);

        if ($update->getData()->success) {
            return redirect()->route('admin.category.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {

        $isError = false;
        $errorData = [];

        if ($category->products->count()) {
            $isError = true;
            $errorData[] = __('app.product');
        }

        if ($category->subcategories->count()) {
            $isError = true;
            $errorData[] = __('app.subcategory');
        }

        if ($isError) {

            $message = __('app.this_category_contains').' '.implode(',', $errorData);

            return error($message);
        }

        $category->delete();

        return success(__('app.category_deleted_successfully'));

    }

    public function getList(Request $request): JsonResponse
    {
        $categories = $this->categoryService->getList($request);

        if ($categories->getData()->success) {
            return response()->json($categories->getData()->data);
        }

        return response()->json([]);

    }

    public function statusUpdate(Category $category): JsonResponse
    {
        $category->status = ! $category->status;
        $category->save();

        return success(__('app.category_status_updated_successfully'), $category);
    }
}
