<?php

namespace App\Services;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressService
{
    public function create(StoreAddressRequest $request, User $user): JsonResponse
    {
        try {
            $input = $request->except('_token');
            $input['user_id'] = $user->id;

            $address = Address::create($input);

            return success('Address created successfully', $address, 201);
        } catch (\Exception $e) {
            logError('Address Store Error ', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        try {
            $input = $request->except('_token', '_method');
            $address->update($input);

            return success(__('app.address_updated_successfully'), $address);
        } catch (\Exception $e) {
            logError('Address Update Error ', $e);

            return error('Something went wrong');
        }

    }

    public function getList(Request $request, User $user): JsonResponse
    {
        try {
            $columns = [
                0 => 'title',
                1 => 'street_address',
                2 => 'apt_or_floor',
                3 => 'zip_code',
                4 => 'actions',
            ];

            $addresses = Address::query()->where('user_id', $user->id);

            $totalData = $addresses->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'title';
            }

            if (empty($request->input('search.value'))) {
                $addresses = $addresses
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $addresses = $addresses
                    ->where('title', 'LIKE', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $addresses->count();
            }

            $data = [];

            if (! empty($addresses)) {
                foreach ($addresses as $address) {

                    $editLink = route('admin.addresses.edit', $address->id);

                    $editBtn = "<a href='{$editLink}' class='main-btn primary-btn btn-hover btn-sm edit-btn'><i class='mdi mdi-pencil'></i></a>";
                    $deleteBtn = "<button type='button' onclick=deleteAddress('{$address->id}',this.parentElement.parentElement)  class='main-btn danger-btn btn-hover btn-sm delete-btn'><i class='mdi mdi-trash-can-outline'></i></button>";

                    $title = "<a class='text-dark' href='".route('admin.addresses.edit', $address->id)."'>".$address->title.'</a>';

                    $nestedData['title'] = $title;
                    $nestedData['street_address'] = $address->street_address;
                    $nestedData['apt_or_floor'] = $address->apt_or_floor;
                    $nestedData['zip_code'] = $address->zip_code;
                    $nestedData['actions'] = $editBtn.'&nbsp;&nbsp;'.$deleteBtn;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success(__('app.address_list'), $json_data);
        } catch (\Exception $e) {
            logError('Address List Error ', $e);

            return error('Something went wrong');
        }
    }
}
