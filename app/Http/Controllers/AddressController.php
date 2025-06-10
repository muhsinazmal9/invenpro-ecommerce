<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Models\User;
use App\Services\AddressService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(private AddressService $addressService)
    {
        $this->middleware('can:'.Address::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Address::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Address::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Address::DELETE)->only('destroy');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user): View
    {
        return view('backend.users.addresses.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request, User $user): RedirectResponse
    {
        $create = $this->addressService->create($request, $user);

        if ($create->getData()->success) {
            return redirect()->route('admin.users.show', $user->username)->with('success', 'Address created successfully');
        }

        return redirect()->route('admin.users.show', $user->username)->withInput()->with('error', 'Something went wrong');
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address): View
    {
        return view('backend.users.addresses.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address): View
    {
        return view('backend.users.addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address): RedirectResponse
    {
        $update = $this->addressService->update($request, $address);

        if ($update->getData()->success) {
            return redirect()->route('admin.users.show', $address->user->username)->with('success', $update->getData()->message);
        }

        return redirect()->route('admin.users.show', $address->user->username)->withInput()->with('error', $update->getData()->message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address): RedirectResponse
    {
        $address->delete();

        return redirect()->route('admin.users.show', $address->user?->username)->with('success', 'Address deleted successfully');
    }

    public function getList(Request $request, User $user): JsonResponse
    {

        $addresses = $this->addressService->getList($request, $user);

        if ($addresses->getData()->success) {
            return response()->json($addresses->getData()->data);
        }

        return response()->json([]);
    }
}
