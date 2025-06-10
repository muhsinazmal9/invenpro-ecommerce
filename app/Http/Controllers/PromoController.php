<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePromoRequest;
use App\Http\Requests\UpdatePromoRequest;
use App\Models\Promo;
use App\Services\PromoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private PromoService $promoService)
    {
        //Check user Permissions
        $this->middleware('can:'.Promo::LIST)->only('index', 'getList');
        $this->middleware('can:'.Promo::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Promo::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Promo::DELETE)->only('destroy');
        $this->middleware('can:'.Promo::STATUS_UPDATE)->only('status');
    }

    public function index(): View
    {
        return view('backend.promos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.promos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromoRequest $request): RedirectResponse
    {
        $create = $this->promoService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.promo.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo): View
    {
        return view('backend.promos.edit', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromoRequest $request, Promo $promo): RedirectResponse
    {

        $update = $this->promoService->update($request, $promo);

        if ($update->getData()->success) {
            return redirect()->route('admin.promo.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo): JsonResponse
    {
        $promo->delete();

        return success(__('app.promo_deleted_successfully'));

    }

    public function getList(Request $request): JsonResponse
    {
        $promos = $this->promoService->getList($request);

        if ($promos->getData()->success) {
            return response()->json($promos->getData()->data);
        }

        return response()->json([]);

    }

    public function status(Promo $promo): JsonResponse
    {

        $promo->status = ! $promo->status;
        $promo->save();

        return success(__('app.promo_status_updated_successfully'), $promo);

    }
}
