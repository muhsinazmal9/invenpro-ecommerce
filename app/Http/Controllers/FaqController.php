<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\Category;
use App\Models\Faq;
use App\Services\FaqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        private FaqService $faqService
    ) {
        // Check User Permissions
        $this->middleware('can:'.Faq::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Faq::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Faq::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Faq::DELETE)->only('destroy');
        $this->middleware('can:'.Faq::STATUS_UPDATE)->only('statusUpdate');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::latest()->where('status', true)->get();

        return view('backend.faq.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $create = $this->faqService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.faq.index')->with('success', $create->getData()->message);
        }

        return back()->withInput()->with('error', $create->getData()->message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq): View
    {
        $categories = Category::latest()->where('status', true)->get();

        return view('backend.faq.edit', compact('faq', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $update = $this->faqService->update($request, $faq);

        if ($update->getData()->success) {
            return redirect()->route('admin.faq.index')->with('success', $update->getData()->message);
        }

        return back()->withInput()->with('error', $update->getData()->message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();

        return success(__('app.FAQ_deleted_successfully'));
    }

    public function getList(Request $request): JsonResponse
    {
        $faqs = $this->faqService->getList($request);

        if ($faqs->getData()->success) {
            return response()->json($faqs->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(Faq $faq): JsonResponse
    {
        $faq->status = ! $faq->status;
        $faq->save();

        return success(__('app.faq_status_updated_successfully'), $faq);
    }
}
