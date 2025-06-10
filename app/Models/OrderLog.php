<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'event',
        'activity',
    ];

    public const STATUS_UPDATE = 'status_update';

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function scopeStatus($query)
    {
        return $query->where('event', self::STATUS_UPDATE);
    }
}
