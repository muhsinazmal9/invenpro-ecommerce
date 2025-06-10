<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Activity;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAddresses(): JsonResponse
    {

        $addresses = Address::where('user_id', auth()->user()->id)->latest()->get();

        return success('Address Retrieved successfully', AddressResource::collection($addresses));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validation = validateData([
            'title' => 'required',
            'customer_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'street_address' => 'required',
            'apt_or_floor' => 'nullable',
            'zip_code' => 'required',
            'city' => 'nullable',
            'country' => 'nullable',
            'coordinate' => 'required',
            'type' => 'required',
        ]);

        if ($validation->fails()) {
            return success('Validation Error', $validation->errors());
        }

        $request['user_id'] = auth()->user()->id;

        $address = Address::create($request->all());

        activity()
            ->performedOn(new Address())
            ->causedBy(auth()->user())
            ->event(Activity::CREATED)
            ->withProperties([
                Activity::CREATED => $address->toArray(),
            ])->log('New Address Created');

        return success('Address saved successfully', new AddressResource($address));
    }

    public function show(Address $address): JsonResponse
    {
        if ($address->user_id != auth()->user()->id) {
            return error('You are not authorized to access this resource');
        }

        return success('Address showed successfully', new AddressResource($address));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $validation = validateData([
            'email' => 'email',
            'phone' => 'numeric',
            'apt_or_floor' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
        ]);

        if ($address->user_id != auth()->user()->id) {
            return error('You are not authorized to access this resource');
        }

        if ($validation->fails()) {
            return error('Validation Error', $validation->errors());
        }

        $oldAddress = $address->getOriginal();
        $address->update($request->all());

        activity()
            ->performedOn(new Address())
            ->causedBy(auth()->user())
            ->event(Activity::UPDATED)
            ->withProperties([
                Activity::UPDATED => [
                    'old' => $oldAddress,
                    'new' => $address->toArray(),
                ],
            ])
            ->log('Address Updated');

        return success('Address updated successfully', new AddressResource($address));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        if ($address->user_id != auth()->user()->id) {
            return error('You are not authorized to access this resource');
        }

        $oldAddress = $address->getOriginal();

        $address->delete();

        activity()
            ->performedOn(new Address())
            ->causedBy(auth()->user())
            ->event(Activity::DELETED)
            ->withProperties([
                Activity::DELETED => $oldAddress,
            ])
            ->log('Address Deleted');

        return success('Address deleted successfully');
    }
}
