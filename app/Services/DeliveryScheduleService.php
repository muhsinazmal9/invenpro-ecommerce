<?php

namespace App\Services;

use App\Models\DeliverySchedule;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeliveryScheduleService
{
    public function getList(Request $request): JsonResponse
    {

        if (! checkUserPermission(DeliverySchedule::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'name',
                1 => 'status',
            ];

            $deliverySchedules = DeliverySchedule::query();

            $totalData = $deliverySchedules->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order = 'actions') {
                $order = 'name';
            }

            if (empty($request->input('search.value'))) {
                $deliverySchedules = $deliverySchedules
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            } else {
                $searchInput = $request->input('search.value');

                $deliverySchedules = $deliverySchedules
                    ->where('name', 'LIKE', "%{$searchInput}%")
                    ->orWhere('status', 'LIKE', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = $deliverySchedules->count();
            }

            $data = [];

            if (! empty($deliverySchedules)) {
                foreach ($deliverySchedules as $deliverySchedule) {

                    $deliveryScheduleStatus = Str::ucfirst($deliverySchedule->status);
                    $deliveryScheduleStatusClass = $deliverySchedule->status === DeliverySchedule::STATUS[1] ? 'success' : 'danger';
                    $id = $deliverySchedule->id;

                    $status = "<button
                                onclick=statusUpdate('{$id}',this)
                                class='main-btn {$deliveryScheduleStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$deliveryScheduleStatus}
                                </button>";
                    $nestedData['name'] = $deliverySchedule->name;
                    $nestedData['status'] = $status;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success(__('app.delivery_schedule_list'), $json_data);

        } catch (\Exception $e) {
            logError('DeliverySchedule List Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getSchedules(): array
    {
        $weekends = DeliverySchedule::where('status', DeliverySchedule::STATUS[0])->pluck('name')->toArray();

        $dates = [];
        $startDate = Carbon::today()->format('Y-m-d');
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::createFromFormat('Y-m-d', $startDate);
            if (! in_array($date->format('l'), $weekends)) {
                $dates[] = Carbon::createFromFormat('Y-m-d', $startDate);
            }
            $startDate = $date->addDay()->format('Y-m-d');
        }

        return $dates;
    }
}
