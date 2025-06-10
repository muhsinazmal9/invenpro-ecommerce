<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    public const DISCOUNT_TYPE_FIXED = 'fixed';

    public const DISCOUNT_TYPE_PERCENTAGE = 'percentage';

    public const IMAGE_DIRECTORY = 'assets/img/uploads/campaigns/';

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    public const LIST = 'list_campaigns';

    public const CREATE = 'create_campaigns';

    public const READ = 'read_campaigns';

    public const UPDATE = 'update_campaigns';

    public const DELETE = 'delete_campaigns';

    public const STATUS_UPDATE = 'status_update_campaigns';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'discount',
        'discount_type',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
