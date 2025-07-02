<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Subcategory;
use App\Models\TaxSettings;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\SubsubCategory;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TaxResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {
        $this->middleware('can:'.Product::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Product::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Product::SHOW)->only(['show']);
        $this->middleware('can:'.Product::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Product::DELETE)->only('destroy');
    }

    public function index(): View
    {
        return view('backend.products.index');
    }

    public function create(): View
    {

        $categories = Category::where('status', Category::STATUS['active'])->get(['id', 'name']);
        $subcategories = Subcategory::where('status', Subcategory::STATUS['active'])->get(['id', 'title', 'category_id']);
        $subsubcategories = SubsubCategory::where('status', SubsubCategory::STATUS['active'])->get(['id', 'title', 'subcategory_id']);
        $attributes = Attribute::where('status', Attribute::STATUS['active'])->with('attributeValues')->get();
        $brands = Brand::where('status', Brand::STATUS['active'])->get(['id', 'title']);
        $tags = Tag::where('status', Tag::STATUS['active'])->get(['id', 'title']);
        $tax_settings = TaxSettings::get(['id', 'code']);

        return view('backend.products.create', compact('categories', 'subcategories', 'brands', 'tags', 'subsubcategories', 'tax_settings', 'attributes'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        // dd($request->all());
        $create = $this->productService->store($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.products.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message)->withInput();
    }

    public function show(Product $product): View
    {
        $product = $product->load('category', 'subcategory', 'brand', 'tags', 'images', 'subsubCategory', 'tax');

        return view('backend.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {

        $categories = Category::where('status', Category::STATUS['active'])->get(['id', 'name']);
        $subcategories = Subcategory::where('status', Subcategory::STATUS['active'])->get(['id', 'title', 'category_id']);
        $subsubcategories = SubsubCategory::where('status', SubsubCategory::STATUS['active'])->get(['id', 'title', 'subcategory_id']);

        $brands = Brand::where('status', Brand::STATUS['active'])->get(['id', 'title']);
        $tags = Tag::where('status', Tag::STATUS['active'])->get(['id', 'title']);
        $tax_settings = TaxSettings::get(['id', 'code']);

        // making tags data for tagify format
        $tagsData = $this->makeTagsData($product->tags);

        return
        view(
            'backend.products.edit',
            compact(
                'product',
                'categories',
                'subcategories',
                'brands',
                'tags',
                'tagsData',
                'subsubcategories',
                'tax_settings',
            )
        );
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {

        $update = $this->productService->update($request, $product);

        if ($update->getData()->success) {
            return redirect()->route('admin.products.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message)->withInput();
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return success('Product deleted successfully');
    }

    public function statusUpdate(Product $product): JsonResponse
    {
        $product->status = $product->status === Product::STATUS['published'] ? Product::STATUS['draft'] : Product::STATUS['published'];
        $product->save();

        return success('Product status updated successfully', $product);
    }

    public function featuredUpdate(Product $product): JsonResponse
    {
        $product->featured = ! $product->featured;
        $product->save();

        return success('Product featured status updated successfully', $product);
    }

    public function newArrivalUpdate(Product $product): JsonResponse
    {
        $product->new_arrival = ! $product->new_arrival;
        $product->save();

        return success('Product  New Arrival Status Updated Successfully', $product);
    }

    public function getList(Request $request): JsonResponse
    {

        $products = $this->productService->getList($request);

        if ($products->getData()->success) {
            return response()->json($products->getData()->data);
        }

        return response()->json([]);
    }

    public function deleteMultipleImage(ProductImage $image): JsonResponse
    {

        $imageSrc = public_path($image->source);

        if (file_exists($imageSrc)) {
            deleteImage($imageSrc);
        }

        $image->delete();

        return success('Product image deleted successfully');
    }

    private function makeTagsData($tags): string
    {
        $tagsData = [];
        if ($tags->count()) {
            $tagsData = $tags->map(function ($tag) {

                return [
                    'value' => $tag->title,
                ];

            })->toArray();
        }

        return $tagsData = json_encode($tagsData);

    }

    function getTax(Product $product):JsonResponse
    {
        $tax = $product->tax;
        return success('tax rate retrieved', new TaxResource($tax));
    }


    function checkStock (Product $product):JsonResponse
    {
        if ($product->stock <= 0) {
            return error('out of stock', 403, $product->stock);
        } else {
            return success('in stock', $product->stock);
        }
    }
}
