<?php

namespace App\Http\Controllers;

use App\Models\DeliverySchedule;
use App\Services\DeliveryScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private DeliveryScheduleService $deliveryScheduleService
    ) {
        $this->middleware('can:'.DeliverySchedule::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.DeliverySchedule::STATUS_UPDATE)->only(['statusUpdate']);

    }

    public function index(): View
    {
        return view('backend.delivery_schedule.index');
    }

    public function getList(Request $request): JsonResponse
    {
        $deliverySchedule = $this->deliveryScheduleService->getList($request);

        if ($deliverySchedule->getData()->success) {
            return response()->json($deliverySchedule->getData()->data);
        }

        return response()->json([]);
    }

    public function statusUpdate(DeliverySchedule $delivery_schedule): JsonResponse
    {

        $status = DeliverySchedule::STATUS[0];

        if ($delivery_schedule->status == DeliverySchedule::STATUS[0]) {
            $status = DeliverySchedule::STATUS[1];
        }

        $delivery_schedule->update([
            'status' => $status,
        ]);

        return success(__('app.delivery_schedule_status_updated_successfully'), $delivery_schedule);
    }
}
