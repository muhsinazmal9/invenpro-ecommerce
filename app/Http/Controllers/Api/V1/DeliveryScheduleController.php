<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DeliverySchedule;
use Carbon\Carbon;

class DeliveryScheduleController extends Controller
{
    public function __invoke(DeliverySchedule $deliverySchedule)
    {

        $deliverySchedule = DeliverySchedule::weekday()->get();

        $weekdays = $deliverySchedule->map(function ($day) {
            return strtolower($day->name);
        });

        $today = Carbon::today();

        $nextSixDays = Carbon::today()->addDays(6);

        // get total 7 days date array

        $dateArray = [];
        $index = 1;
        for ($date = $today; $date->lte($nextSixDays); $date->addDay()) {

            if (! in_array(strtolower($date->format('l')), $weekdays->toArray())) {
                continue;
            }

            $dateArray[] = [
                'id' => $index,
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('l'),
            ];

            $index++;
        }

        return success('Delivery Schedule List', $dateArray);

    }
}
