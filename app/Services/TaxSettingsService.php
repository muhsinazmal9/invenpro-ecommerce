<?php

namespace App\Services;

use App\Http\Requests\StoreTaxSettingsRequest;
use App\Http\Requests\UpdateTaxSettingsRequest;
use App\Models\TaxSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaxSettingsService
{
    public function store(StoreTaxSettingsRequest $request): JsonResponse
    {
        try {

            $input = $request->except('_token');

            // code to customized slug
            $code = preg_replace('/-+/', '-', strtoupper(str_replace(' ', '-', $request->code)));

            $input['code'] = $code;
            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->code);
            $tax = TaxSettings::create($input);

            return success('TAX settings created successfully!', $tax);

        } catch (\Exception $e) {
            logError('Tax Settings Store Error ', $e);

            return error('Error updating settings');
        }

    }

    public function update(UpdateTaxSettingsRequest $request, TaxSettings $tax): JsonResponse
    {
        try {

            $input = $request->except('_token', '_method');

            // code to customized slug
            $code = preg_replace('/-+/', '-', strtoupper(str_replace(' ', '-', $request->code)));

            $input['code'] = $code;
            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->code);
            $tax->update($input);

            return success('TAX settings created successfully!', $tax);

        } catch (\Exception $e) {
            logError('Tax Settings Store Error ', $e);

            return error('Error updating settings');
        }

    }

    public function getList(Request $request): JsonResponse
    {
        if (! checkUserPermission(TaxSettings::TAX_SETTINGS)) {
            return error('Permission Denied!');
        }

        try {
            $columns = [
                0 => 'code',
                1 => 'rate',
                2 => 'status',
                3 => 'created_at',
                4 => 'actions',
            ];

            $taxSettings = TaxSettings::query();

            $totalData = $taxSettings->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            info('Order: ', [$dir]);

            if (empty($request->input('search.value'))) {
                $taxSettings = $taxSettings
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $taxSettings = $taxSettings
                    ->where('code', 'LIKE', "%{$searchInput}%")
                    ->orWhere('rate', 'LIKE', "%{$searchInput}%")
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
                $totalFiltered = $taxSettings->count();
            }

            $data = [];

            if (! empty($taxSettings)) {
                foreach ($taxSettings as $taxSetting) {

                    $taxStatus = $taxSetting->status ? 'Enabled' : 'Disabled';
                    $taxStatusClass = $taxSetting->status ? 'success' : 'danger';
                    $taxData = [
                        'slug' => $taxSetting->slug,
                        'code' => $taxSetting->code,
                        'rate' => $taxSetting->rate,
                        'status' => $taxSetting->status,
                    ];

                    $taxData = json_encode($taxData);

                    $status = "<button
                                onclick=taxStatusUpdate('{$taxSetting->slug}',this)
                                class='main-btn {$taxStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$taxStatus}</button>";
                    $view = 'View';
                    $edit = 'Edit';
                    $delete = 'Delete';

                    $editBtn = "<button data='{$taxData}' type='button' onclick=editTax(this) class='dropdown-item'>{$edit}</button>";
                    $deleteBtn = "<button type='button' onclick=deleteTax(':slug',this.parentElement.parentElement)  class='dropdown-item'>{$delete}</button>";

                    // replace the :slug with the actual category slug
                    $deleteBtn = str_replace(':slug', $taxSetting->slug, $deleteBtn);

                    $nestedData['code'] = $taxSetting->code;
                    $nestedData['rate'] = $taxSetting->rate.'%';
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $taxSetting->created_at?->format('d/m/y');
                    $nestedData['actions'] ="<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
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

            return success('Tax Settings List', $json_data);

        } catch (\Exception $e) {
            logError('Category List Error ', $e);

            return error('Error getting settings');
        }

    }
}
