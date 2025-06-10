<?php

namespace App\Services;

use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Models\Deal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DealService
{
    public function create(StoreDealRequest $request): JsonResponse
    {
        try {
            $slug = Str::slug($request->title);
            $input = $request->except('_token', 'product_ids', 'image');
            $input['slug'] = $slug;
            $input['status'] = (bool) $request->status;

            if ($request->has('image')) {
                $image = $request->image;
                $name = $slug.'-'.rand(1000, 9999).'.'.'webp';
                $localPath = Deal::IMAGE_DIRECTORY.$name;
                $path = public_path($localPath);
                saveImage($image, $path);
                $input['image'] = $localPath;
            }

            $deal = Deal::create($input);

            $product_ids = (array) json_decode($request->product_ids);
            $product_integer_ids = array_map('intval', $product_ids);
            $product_integer_ids = array_unique($product_integer_ids);
            $deal->products()->attach($product_integer_ids);

            return success('Deal created successfully', $deal);
        } catch (\Exception $ex) {
            logError('Deal Store Error ', $ex);

            return error('Something went wrong', data: $ex);
        }
    }

    public function update(UpdateDealRequest $request, Deal $deal): JsonResponse
    {
        try {
            $input = $request->except('_token', 'product_ids', 'image');
            $slug = Str::slug($request->title);
            $input['slug'] = $slug;
            $input['status'] = (bool) $request->status;

            if ($request->has('image') && $request->image != null && $request->image != '') {

                $oldImage = public_path($deal->image);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }

                $image = $request->image;
                $name = $slug.'-'.rand(1000, 9999).'.'.'webp';
                $localPath = Deal::IMAGE_DIRECTORY.$name;
                $path = public_path($localPath);
                saveImage($image, $path);
                $input['image'] = $localPath;
            }

            $deal->update($input);
            $product_ids = (array) json_decode($request->product_ids);
            $product_integer_ids = array_map('intval', $product_ids);
            $product_integer_ids = array_unique($product_integer_ids);
            $deal->products()->sync($product_integer_ids);

            return success('Deal updated successfully', $deal);

        } catch (\Exception $ex) {
            logError('Deal Update Error ', $ex);

            return error($ex->getMessage());
        }

    }

    public function getList(Request $request): JsonResponse
    {

        try {
            $columns = [
                0 => 'title',
                1 => 'date',
                2 => 'status',
                3 => 'created_at',
                4 => 'actions',
            ];

            $deals = Deal::query();
            $totalData = $deals->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'title';

            if ($order == 'actions') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $deals = $deals->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');
                $deals = $deals->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('date', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $deals->count();
            }

            $data = [];

            if (! empty($deals)) {
                foreach ($deals as $deal) {

                    $img = "<img src='".asset($deal->image)."' class='img-thumbnail' width='100' height='100'>";

                    $title = $img.' '.$deal->title;
                    $editLink = route('admin.deals.edit', $deal->slug);
                    $detailsLink = route('admin.deals.show', $deal->slug);

                    $statusClass = $deal->status ? 'success' : 'danger';
                    $SubCategoryStatus = $deal->status ? __('app.enabled') : __('app.disabled');

                    $status = "<button type='button'' onclick=statusUpdate('{$deal->slug}',this) class='main-btn {$statusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px'>
                                    {$SubCategoryStatus}
                                </button>";
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');

                    $editBtn = "<a href='{$editLink}' class='dropdown-item' >{$edit}</a>";
                    $deleteBtn = "<button type='button' onclick=deleteDeal('{$deal->slug}',this.parentElement.parentElement) class='dropdown-item' >{$delete} </button>";

                    $detailsBtn = "<a href='{$detailsLink}'  class='dropdown-item'>{$view}</a>";

                    $nestedData['title'] = $title;
                    $nestedData['date'] = $deal->date?->format('d-m-Y');
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $deal->created_at->format('d-m-Y');
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

            $json = [
                'draw' => intval($request->draw),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('Deals fetched successfully', $json);
        } catch (\Exception $ex) {
            logError('Deal List Error ', $ex);

            return error($ex->getMessage());
        }

    }

    public function detailList(Request $request): JsonResponse
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
                9 => 'new_arrival',
                10 => 'status',
            ];

            info($request->slug);

            $products = Deal::where('slug', $request->slug)->first()->products;

            $totalData = $products->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions' || $order == 'thumbnail') {
                $order = 'title';
            }
            if (! empty($request->input('search.value'))) {

                $searchInput = $request->input('search.value');

                $products = $products->filter(function ($product) use ($searchInput) {

                    return Str::contains($product->title, $searchInput) ||
                    Str::contains($product->sku, $searchInput) ||
                    Str::contains($product->price, $searchInput) ||
                    Str::contains($product->stock, $searchInput) ||
                    Str::contains($product->brand, $searchInput) ||
                    Str::contains($product->category, $searchInput) ||
                    Str::contains($product->subcategory, $searchInput) ||
                    Str::contains($product->sub_subcategory, $searchInput);

                });

                $totalFiltered = $products->count();

            }

            $data = [];

            if (! empty($products)) {
                foreach ($products as $product) {
                    /**
                     * HTMLs
                     */
                    $productStatus = $product->status == 'published' ? __('app.published') : __('app.draft');
                    $statusClass = $product->status == 'published' ? 'success' : 'secondary';
                    $isFeatured = $product->featured ? __('app.yes') : __('app.no');
                    $featuredClass = $product->featured ? 'success' : 'danger';
                    $isnewArrival = $product->new_arrival ? __('app.yes') : __('app.no');
                    $newarrivalClass = $product->new_arrival ? 'success' : 'danger';

                    $detailsLink = route('admin.products.show', $product->slug);
                    $status = "<button class='main-btn {$statusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px' type='button' onclick=statusUpdate('{$product->slug}',this) >{$productStatus}</button>";
                    $featuresHtml = "<button class='main-btn {$featuredClass}-btn-light btn-hover btn-sm' style='padding:4px 20px' type='button' onclick=featuredUpdate('{$product->slug}',this) >{$isFeatured}</button>";
                    $newarrivalHtml = "<button class='main-btn {$newarrivalClass}-btn-light btn-hover btn-sm' style='padding:4px 20px' type='button' onclick=newarrivalUpdate('{$product->slug}',this) >{$isnewArrival}</button>";

                    $thumbnail = '<img src="'.asset($product->thumbnail).'" alt="'.$product->title.'" class="img-fluid rounded" style="max-width: 100px">';
                    $titleRow = "<a href='{$detailsLink}' class='text-dark'>{$product->title}</a>";

                    $nestedData['thumbnail'] = $thumbnail;
                    $nestedData['title'] = $titleRow;
                    $nestedData['sku'] = $product->sku;
                    $nestedData['price'] = number_format($product->price, 2);
                    $nestedData['stock'] = $product->stock;
                    $nestedData['category_id'] = $product->category?->name;
                    $nestedData['subcategory_id'] = $product->subcategory?->title;
                    $nestedData['subsub_category_id'] = $product->subSubcategory?->title;
                    $nestedData['brand_id'] = $product->brand?->title;
                    $nestedData['featured'] = $featuresHtml;
                    $nestedData['new_arrival'] = $newarrivalHtml;
                    $nestedData['status'] = $status;
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
