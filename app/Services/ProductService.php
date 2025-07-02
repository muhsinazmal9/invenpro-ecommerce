<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeItem;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductService
{
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $request['slug'] = generateSlug($request->title); 
 
            $product = Product::create($request->except('thumbnail', 'image_gallery', 'size_chart'));

            if ($request->has('thumbnail')) {

                $thumbnail = $request->thumbnail;
                $thumbnailName = $product->slug.'.webp';
                $localPath = Product::THUMBNAIL_DIRECTORY.$thumbnailName;
                $path = public_path($localPath);
                saveImage($thumbnail, $path);
                $product->update(['thumbnail' => $localPath]);
            }

            if ($request->has('size_chart')) {

                $sizeChart = $request->size_chart;
                $sizeChartName = $product->slug.'.webp';
                $localPath = Product::SIZE_CHART_DIRECTORY.$sizeChartName;
                $path = public_path($localPath);
                saveImage($sizeChart, $path);
                $product->update(['size_chart' => $localPath]);
            }

            if ($request->has('image_gallery')) {
                $this->uploadGalleryImage($product, $request->image_gallery);
            }
            if ($request->tags) {
                $this->syncTags($product, $request->tags);
            }
            // $this->addAttributes($product, $request);
            // $this->addCustomAttributes($product, $request);

            return success('Product created successfully', $product);

        } catch (\Exception $e) {
            logError('Product Store Error', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $inputs = $request->except('_token', '_method', 'thumbnail');

        try {
            $request['slug'] = generateSlug($request->title); 

            if ($request->has('thumbnail') && $request->thumbnail != null && $request->thumbnail != '') {

                $oldImage = public_path($product->thumbnail);

                if (file_exists($oldImage)) {
                    deleteImage($product->thumbnail);
                }

                $thumbnail = $request->thumbnail;
                $thumbnailName = $product->slug.'-'.time().'.webp';
                $localPath = Product::THUMBNAIL_DIRECTORY.$thumbnailName;
                $path = public_path($localPath);
                saveImage($thumbnail, $path);

                $inputs['thumbnail'] = $localPath;
            }

            if ($request->has('size_chart') && $request->size_chart != null && $request->size_chart != '') {

                $oldImage = public_path($product->size_chart);

                if (file_exists($oldImage)) {
                    deleteImage($product->size_chart);
                }

                $size_chart = $request->size_chart;
                $sizeChartName = $product->slug.'-'.time().'.webp';
                $localPath = Product::SIZE_CHART_DIRECTORY.$sizeChartName;
                $path = public_path($localPath);
                saveImage($size_chart, $path);

                $inputs['size_chart'] = $localPath;
            }

            $product->update($inputs);

            if ($request->has('image_gallery')) {
                $this->uploadGalleryImage($product, $request->image_gallery);
            }

            if ($request->tags) {
                $this->syncTags($product, $request->tags);
            }
            $product->attributes()->delete();
            $this->addAttributes($product, $request);

            $product->customAttributes()->delete();
            $this->addCustomAttributes($product, $request);

            return success('Product updated successfully', $product);

        } catch (\Exception $e) {
            logError('Product Store Error', $e);

            return error('Something went wrong');
        }
    }

    private function uploadGalleryImage(Product $product, array $images): void
    {

        $data = [];
        foreach ($images as $key => $image) {

            $filename = $product->slug.'-'.time().$key.'.webp';
            $localLocation = Product::GALLERY_IMG_PATH.$filename;

            saveImage($image, $localLocation);

            $data[] = [
                'product_id' => $product->id,
                'source' => $localLocation,
            ];

        }

        ProductImage::insert($data);

    }

    private function syncTags(Product $product, string $requestedTags): void
    {

        $tagsArray = json_decode($requestedTags, true);

        foreach ($tagsArray as $key => $tag) {
            $tags[$key] = $tag['value'];
        }

        if (! empty($tags)) {
            $tagsId = [];

            foreach ($tags as $req_tag) {

                $tag = Tag::where('title', $req_tag)
                    ->firstOrCreate([
                        'title' => $req_tag,
                        'slug' => generateSlug($req_tag),
                        'status' => Tag::STATUS['active'],
                    ]);

                $tagsId[] = $tag->id;
            }

            $product->tags()->sync($tagsId);
        }
    }

    private function addAttributes(Product $product, StoreProductRequest|UpdateProductRequest $request): void
    {

        if ($request->has('name_attr')) {

            $attributesData = [];

            foreach ($request->name_attr as $keyData => $attrName) {
                $key = $request->attribute_wrapper[$keyData];
                $itemNameAttr = $request->{'item_name_attr_'.$key};

                if (empty($attrName) || empty($request->type_attr[$keyData]) || $itemNameAttr == null || empty($itemNameAttr[0])) {
                    continue;
                }

                $attributesData[] = [
                    'product_id' => $product->id,
                    'name' => $attrName,
                    'type' => $request->type_attr[$keyData],
                ];
            }

            ProductAttribute::insert($attributesData);

            $attributes = ProductAttribute::where('product_id', $product->id)->get('id');

            $productAttrItemsData = [];
            foreach ($request->name_attr as $keyData => $attrName) {
                $key = $request->attribute_wrapper[$keyData];
                $itemNameAttr = $request->{'item_name_attr_'.$key};

                if (empty($attrName) || empty($request->type_attr[$keyData]) || $itemNameAttr == null || empty($itemNameAttr[0])) {
                    continue;
                }

                foreach ($itemNameAttr as $itemKey => $item) {

                    if (empty($item)) {
                        continue;
                    }

                    $priceAdjustment = $request->{'price_adjustment_attr_'.$key}[$itemKey] ?? 0;
                    $code = $request->{'code_attr_'.$key}[$itemKey];

                    $productAttrItemsData[] = [
                        'attribute_id' => $attributes[$keyData]->id,
                        'name' => $item,
                        'price_adjustment' => $priceAdjustment,
                        'code' => $code,
                    ];
                }
            }

            ProductAttributeItem::insert($productAttrItemsData);

        }
    }

    private function addCustomAttributes(Product $product, StoreProductRequest|UpdateProductRequest $request): void
    {
        if ($request->filled('custom_attributes')) {
            $customAttributesData = collect($request->custom_attributes)->map(fn($attr) => [
                'product_id' => $product->id,
                'key' => $attr['key'],
                'value' => $attr['value'],
            ])->all();
            
            $product->customAttributes()->createMany($customAttributesData);
        }
    }

    public function getList(Request $request): JsonResponse
    {
        try {
            $columns = [
                'thumbnail',
                'title',
                'sku',
                'price',
                'stock',
                'category_id',
                'subcategory_id',
                'subsub_category_id',
                'brand_id',
                'featured',
                'new_arrival',
                'status',
                'created_at',
                'actions',
            ];

            $data = Product::datatable($request, $columns, [
                'with' => ['category', 'subcategory', 'subSubcategory', 'brand'],
                'searchables' => [
                    'title', 'sku', 'price', 'stock',
                    'category.name', 'subcategory.title', 'brand.title'
                ],
                'modifyQuery' => function ($query) use ($request) {
                    $queryParams = explode(',', $request->input('query'));
                    if (in_array(Product::LOW_STOCK, $queryParams)) {
                        $query->low();
                    }
                    if (in_array(Product::TOP_PRODUCT, $queryParams)) {
                        $query->whereHas('orders', function ($q) {
                            $q->where('order_status', Order::ORDER_STATUS['delivered'])
                            ->where('payment_status', Order::PAYMENT_STATUS['paid']);
                        });
                    }
                    return $query;
                },
                'formatRow' => function ($row, $product) {
                    $lowStock = getSetting('low_stock');
                    $row['thumbnail'] = '<img src="' . asset($product->thumbnail) . '" class="img-fluid rounded" style="max-width: 100px">';
                    $row['title'] = '<a href="' . route('admin.products.edit', $product->slug) . '" class="text-dark">' . e($product->title) . '</a>';
                    $row['stock'] = $product->stock <= $lowStock ? "<span class='text-danger'>{$product->stock}</span>" : $product->stock;
                    $row['price'] = number_format($product->price, 2);

                    $row['status'] = /* view('components.datatable.status', ['product' => $product])->render() */ '';
                    $row['featured'] = /* view('components.datatable.featured', ['product' => $product])->render() */ '';
                    $row['new_arrival'] = /* view('components.datatable.new_arrival', ['product' => $product])->render() */ '';
                    $row['actions'] = /* view('components.datatable.actions', ['product' => $product])->render() */ '';
                    return $row;
                }
            ]);

            return success('Product List', $data);
        } catch (\Exception $e) {
            logError('Product List Error', $e);
            return error('Something went wrong');
        }
    }

}
