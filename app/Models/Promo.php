<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const LIST = 'list_promo';

    public const CREATE = 'create_promo';

    public const UPDATE = 'update_promo';

    public const DELETE = 'delete_promo';

    public const STATUS_UPDATE = 'status_update_promo';

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    public const DISCOUNT_TYPE = [
        'fixed' => 'FIXED',
        'percentage' => 'PERCENTAGE',
    ];

    protected $fillable = [
        'title',
        'limit',
        'slug',
        'status',
        'code',
        'discount',
        'discount_type',
    ];

    protected $casts = [
        'status' => 'boolean',
        'limit' => 'integer',
        'discount' => 'double',
    ];
}
