<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaxSettingsRequest;
use App\Http\Requests\UpdateTaxSettingsRequest;
use App\Models\TaxSettings;
use App\Services\TaxSettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaxSettingsController extends Controller
{
    public function __construct(private TaxSettingsService $taxSettingsService)
    {
        $this->middleware('can:'.TaxSettings::TAX_SETTINGS)->only(['index', 'store', 'update', 'destroy']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.settings.tax_settings.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaxSettingsRequest $request): JsonResponse
    {
        try {
            $taxSettings = $this->taxSettingsService->store($request);

            return success(__('app.tax_settings_created_successfully'), $taxSettings);

        } catch (\Exception $e) {
            logError('Tax Settings Store Error ', $e);

            return error(__('app.error_updating_settings'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxSettingsRequest $request, TaxSettings $tax)
    {
        try {
            $this->taxSettingsService->update($request, $tax);

            return success(__('app.tax_settings_updated_successfully'));

        } catch (\Exception $e) {
            logError('Tax Settings Update Error ', $e);

            return error(__('app.error_updating_settings'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaxSettings $tax)
    {

        if ($tax->products?->count()) {
            return error(' This tax contain products');

        }
        $tax->delete();

        return success(__('app.tax_settings_deleted_successfully'));
    }

    public function getList(Request $request): JsonResponse
    {
        $taxSettings = $this->taxSettingsService->getList($request);

        if ($taxSettings->getData()->success) {
            return response()->json($taxSettings->getData()->data);
        }

        return response()->json([]);

    }

    public function status(TaxSettings $tax): JsonResponse
    {
        $tax->status = ! $tax->status;
        $tax->save();

        return success(__('app.tax_settings_status_updated'), $tax);
    }
}
