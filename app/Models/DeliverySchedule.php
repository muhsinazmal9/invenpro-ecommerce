<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySchedule extends Model
{
    use HasFactory;

    public const LIST = 'list_delivery_schedule';

    public const STATUS_UPDATE = 'status_update_delivery_schedule';

    public const STATUS = [
        1 => 'weekday',
        0 => 'weekend',
    ];

    protected $fillable = [
        'name',
        'status',
    ];

    public const DAYS = [
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
        'sunday' => 'Sunday',
    ];

    public function scopeWeekday($query)
    {
        return $query->where('status', self::STATUS[1]);
    }
}
