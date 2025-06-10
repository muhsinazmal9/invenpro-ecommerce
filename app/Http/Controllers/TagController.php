<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private TagService $tagService)
    {
        // Check User Permissions
        $this->middleware('can:'.Tag::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Tag::CREATE)->only(['create', 'store']);
        $this->middleware('can:'.Tag::UPDATE)->only(['edit', 'update']);
        $this->middleware('can:'.Tag::DELETE)->only('destroy');
        $this->middleware('can:'.Tag::STATUS_UPDATE)->only('status');
    }

    public function index(): View
    {
        return view('backend.tags.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {

        $create = $this->tagService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.tags.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message)->withInput();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag): View
    {
        return view('backend.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $update = $this->tagService->update($request, $tag);

        if ($update->getData()->success) {
            return redirect()->route('admin.tags.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message)->withInput();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();

        return success('Tag deleted successfully');
    }

    public function getList(Request $request): JsonResponse
    {
        $tags = $this->tagService->getList($request);

        if ($tags->getData()->success) {
            return response()->json($tags->getData()->data);
        }

        return response()->json([]);

    }

    public function status(Tag $tags): JsonResponse
    {
        $tags->status = ! $tags->status;
        $tags->save();

        return success('Tag status updated successfully', $tags);
    }
}
