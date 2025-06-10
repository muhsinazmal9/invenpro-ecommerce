<?php

namespace App\Services;

use App\Http\Requests\StorePromoRequest;
use App\Http\Requests\UpdatePromoRequest;
use App\Models\Promo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoService
{
    public function create(StorePromoRequest $request): JsonResponse
    {
        try {
            $input = $request->except('_token');
            $input['slug'] = generateSlug($request->title);
            $input['status'] = (bool) $request->status;
            $promo = Promo::create($input);

            return success(__('app.promo_created_successfully'), $promo);
        } catch (\Exception $e) {
            logError('promo Store Error ', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdatePromoRequest $request, Promo $promo): JsonResponse
    {

        try {
            $input = $request->except('_token', '_method');
            $input['slug'] = generateSlug($request->title);
            $input['status'] = (bool) $request->status;
            $promo->update($input);

            return success(__('app.promo_updated_successfully'), $promo);
        } catch (\Exception $e) {
            logError('Promo Update Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {

        if (! checkUserPermission(Promo::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'title',
                1 => 'limit',
                2 => 'code',
                3 => 'discount',
                4 => 'discount_type',
                5 => 'status',
                6 => 'actions',
            ];

            $promos = Promo::query();

            $totalData = $promos->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')] ?? 'id';
            $dir = $request->input('order.0.dir', 'desc');

            if ($order == 'actions') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $promos = $promos
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $promos = $promos
                    ->where('title', 'LIKE', "%{$searchInput}%")
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
                $totalFiltered = $promos->count();
            }

            $data = [];

            if (! empty($promos)) {
                foreach ($promos as $promo) {

                    $promoStatus = $promo->status ? __('app.enabled') : __('app.disabled');
                    $promoStatusClass = $promo->status ? 'success' : 'danger';
                    $slug = $promo->slug;

                    $status = "<button
                                onclick=promoStatusUpdate('{$slug}',this)
                                class='main-btn {$promoStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$promoStatus}
                                </button>";
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');


                    $editBtn = "<a
                                href='".route('admin.promo.edit', $promo->slug)."'
                                   class='dropdown-item'>{$edit}</a>";

                    $deleteBtn = "<button
                                        type='button'
                                        onclick=deletePromo(':slug',this.parentElement.parentElement)
                                        class='dropdown-item'>
                                        {$delete}
                                    </button>";

                    // replace the :slug with the actual category slug
                    $deleteBtn = str_replace(':slug', $promo->slug, $deleteBtn);

                    $detailBtn = "<button
                                    type='button'
                                    data-bs-toggle='modal'
                                    data-bs-target='#detailsModal'
                                    class='dropdown-item'
                                    onclick='detailsModal({$promo})'>
                                       {$view}
                                </button>";

                    $nestedData['title'] = $promo->title;
                    $nestedData['limit'] = $promo->limit;
                    $nestedData['code'] = $promo->code;
                    $nestedData['discount'] = $promo->discount;
                    $nestedData['discount_type'] = $promo->discount_type;
                    $nestedData['status'] = $status;
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        {$detailBtn}
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

            return success(__('app.promo_list'), $json_data);
        } catch (\Exception $e) {
            logError('Promo List Error ', $e);

            return error('Something went wrong');
        }
    }
}
