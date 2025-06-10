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
            $this->addAttributes($product, $request);
            $this->addCustomAttributes($product, $request);

            return success(__('app.product_created_successfully'), $product);

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

            return success(__('app.product_updated_successfully'), $product);

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
                0 => 'thumbnail',
                1 => 'title',
                2 => 'sku',
                3 => 'price',
                4 => 'stock',
                5 => 'category_id',
                6 => 'subcategory_id',
                7 => 'subsub_category_id',
                8 => 'brand_id',
                9 => 'featured',
                10 => 'new_arrival',
                11 => 'status',
                12 => 'created_at',
                13 => 'actions',
            ];

            $products = Product::query()
            ->with(['category:id,name', 'subcategory:id,title', 'subSubcategory:id,title', 'brand:id,title']);

            $queryParam = explode(',', $request->input('query'));

            if (in_array(Product::LOW_STOCK, $queryParam)) {
                $products = $products->low();
            }

            if (in_array(Product::TOP_PRODUCT, $queryParam)) {
                $products = $products
                    ->whereHas('orders', function ($query) {
                        $query->where('order_status', Order::ORDER_STATUS['delivered'])
                            ->where('payment_status', Order::PAYMENT_STATUS['paid']);
                    });
            }

            $totalData = $products->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions' || $order == 'thumbnail') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $products = $products
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $products = $products
                    ->where('title', 'like', "%{$searchInput}%")
                    ->orWhere('sku', 'like', "%{$searchInput}%")
                    ->orWhere('price', 'like', "%{$searchInput}%")
                    ->orWhere('stock', 'like', "%{$searchInput}%")
                    ->orWhereHas('category', function ($query) use ($searchInput) {
                        $query->where('name', 'like', "%{$searchInput}%");
                    })
                    ->orWhereHas('subcategory', function ($query) use ($searchInput) {
                        $query->where('title', 'like', "%{$searchInput}%");
                    })
                    // ->orWhereHas('sub_subcategory', function ($query) use ($searchInput) {
                    //     $query->where('title', 'like', "%{$searchInput}%");
                    // })
                    ->orWhereHas('brand', function ($query) use ($searchInput) {
                        $query->where('title', 'like', "%{$searchInput}%");
                    })
                    ->orWhere(function ($query) use ($searchInput) {
                        if ($searchInput == 'enabled') {
                            $query->where('status', true);
                        }
                        if ($searchInput == 'disabled') {
                            $query->where('status', false);
                        }
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $products->count();
            }

            $data = [];

            $lowStock = getSetting('low_stock');

            if (! empty($products)) {
                foreach ($products as $product) {
                    /**
                     * HTMLs
                     */
                    $productStatus = $product->status == Product::STATUS['published'] ? __('app.published') : __('app.draft');
                    $statusClass = $product->status == Product::STATUS['published'] ? 'success' : 'secondary';
                    $isFeatured = $product->featured ? __('app.yes') : __('app.no');
                    $featuredClass = $product->featured ? 'success' : 'danger';
                    $isNewArrival = $product->new_arrival ? __('app.yes') : __('app.no');
                    $newArrivalClass = $product->new_arrival ? 'success' : 'danger';

                    $editLink = route('admin.products.edit', $product->slug);
                    $detailsLink = route('admin.products.show', $product->slug);

                    $status = "<button class='main-btn {$statusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px' type='button' onclick=statusUpdate('{$product->slug}',this) >{$productStatus}</button>";
                    $featuresHtml = "<button class='main-btn {$featuredClass}-btn-light btn-hover btn-sm' style='padding:4px 20px' type='button' onclick=featuredUpdate('{$product->slug}',this) >{$isFeatured}</button>";
                    $newArrivalHtml = "<button class='main-btn {$newArrivalClass}-btn-light btn-hover btn-sm' style='padding:4px 20px' type='button' onclick=newarrivalUpdate('{$product->slug}',this) >{$isNewArrival}</button>";

                    // action buttons
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');
                    $detailsBtn = "<a href='{$detailsLink}' class='dropdown-item'>{$view}</a>";
                    $editBtn = "<a href='{$editLink}' class='dropdown-item'>{$edit}</a>";
                    $deleteBtn = "<button type='button' class='dropdown-item' onclick='deleteProduct(\"{$product->slug}\")'>{$delete}</a>";

                    // image
                    $thumbnail = '<img src="'.asset($product->thumbnail).'" alt="'.$product->title.'" class="img-fluid rounded" style="max-width: 100px">';

                    $titleRow = "<a href='{$editLink}' class='text-dark'>{$product->title}</a>";

                    $lowStockColor = ($product->stock <= $lowStock) ? 'text-danger' : '';
                    $productStock = "<span class='{$lowStockColor}'>{$product->stock}</span>";

                    $nestedData['thumbnail'] = $thumbnail;
                    $nestedData['title'] = $titleRow;
                    $nestedData['sku'] = $product->sku;
                    $nestedData['price'] = number_format($product->price, 2);
                    $nestedData['stock'] = $productStock;
                    $nestedData['category_id'] = $product->category?->name;
                    $nestedData['subcategory_id'] = $product->subcategory?->title;
                    $nestedData['subsub_category_id'] = $product->subSubcategory?->title;
                    $nestedData['brand_id'] = $product->brand?->title;
                    $nestedData['featured'] = $featuresHtml;
                    $nestedData['new_arrival'] = $newArrivalHtml;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $product->created_at?->format('d/m/y');
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                        <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fa-solid fa-ellipsis'></i>
                        </button>
                        <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                            {$detailsBtn}
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

            return success('Product List', $json_data);

        } catch (\Exception $e) {
            logError('Product List Error', $e);

            return error('Something went wrong');
        }
    }
}
