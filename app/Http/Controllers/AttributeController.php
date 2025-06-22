<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Services\AttributeService;

class AttributeController extends Controller
{

    public function __construct(
        private AttributeService $attributeService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $create = $this->attributeService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully');
        }

        return back()->with('error', $create->getData()->message)->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('backend.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $update = $this->attributeService->update($request, $attribute);

        if ($update->getData()->success) {
            return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully');
        }

        return back()->with('error', $update->getData()->message)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        //
    }

    public function getList(Request $request)
    {
        $attributes = $this->attributeService->getList($request);
        return response()->json($attributes);
    }
}
