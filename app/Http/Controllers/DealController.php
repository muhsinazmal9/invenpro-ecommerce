<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Models\Deal;
use App\Models\Product;
use App\Services\DealService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function __construct(
        private DealService $dealService
    ) {

    }

    public function index(): View
    {
        return view('backend.deals.index');
    }

    public function create(): View
    {
        return view('backend.deals.create');
    }

    public function store(StoreDealRequest $request)
    {

        $create = $this->dealService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully');
        }

        return back()->with('error', $create->getData()->message)->withInput();
    }

    public function edit(Deal $deal)//: View
    {
        $deal->load('products');

        return view('backend.deals.edit', compact('deal'));
    }

    public function show(Deal $deal)
    {

        return view('backend.deals.show', compact('deal'));
    }

    public function update(UpdateDealRequest $request, Deal $deal): RedirectResponse
    {
        $update = $this->dealService->update($request, $deal);

        if ($update->getData()->success) {
            return redirect()->route('admin.deals.index')->with('success', 'Deal updated successfully');
        }

        return back()->with('error', $update->getData()->message)->withInput();
    }

    public function getList(Request $request): JsonResponse
    {
        $list = $this->dealService->getList($request);

        if ($list->getData()->success) {
            return response()->json($list->getData()->data);
        }

        return response()->json([]);
    }

    public function destroy(Deal $deal): JsonResponse
    {
        try {
            $deal->delete();
            $deal->products()->detach();

            return success('Deal deleted successfully');
        } catch (\Exception $ex) {
            logError('Deal Delete Error ', $ex);

            return error($ex->getMessage());
        }
    }

    public function productDestroy(Deal $deal, Product $product): JsonResponse
    {
        try {
            $deal->products()->detach([$product->id]);

            return success('Deal product deleted successfully');
        } catch (\Exception $ex) {
            logError('Deal Product Delete Error ', $ex);

            return error($ex->getMessage());
        }
    }

    public function statusUpdate(Deal $deal): JsonResponse
    {
        try {
            $deal->update(['status' => ! $deal->status]);

            return success('Deal status updated successfully', $deal);
        } catch (\Exception $ex) {
            logError('Deal Status Update Error ', $ex);

            return error($ex->getMessage());
        }
    }

    public function detailsList(Request $request, Deal $deal): JsonResponse
    {

        $list = $this->dealService->detailList($request, $deal);

        if ($list->getData()->success) {
            return response()->json($list->getData()->data);
        }

        return response()->json([]);
    }
}
