<?php

namespace Database\Seeders;

use App\Models\DeliverySchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $delivery_schedules = [
            [
                'name' => DeliverySchedule::DAYS['monday'],
                'status' => DeliverySchedule::STATUS[1],
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::DAYS['tuesday'],
                'status' => DeliverySchedule::STATUS[1],
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::DAYS['wednesday'],
                'status' => DeliverySchedule::STATUS[1],
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::DAYS['thursday'],
                'status' => DeliverySchedule::STATUS[1],
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::DAYS['friday'],
                'status' => DeliverySchedule::STATUS[1],
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::DAYS['saturday'],
                'status' => DeliverySchedule::STATUS[1],
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::DAYS['sunday'],
                'status' => DeliverySchedule::STATUS[1],
                'created_at' => now(),
            ],

        ];
        $db = DB::table('delivery_schedules');
        $db->truncate();
        $db->insert($delivery_schedules);

    }
}
