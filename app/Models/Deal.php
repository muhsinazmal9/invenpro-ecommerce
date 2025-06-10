<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const LIST = 'list_deals';

    public const CREATE = 'create_deal';

    public const UPDATE = 'update_deal';

    public const DELETE = 'delete_deal';

    public const STATUS_UPDATE = 'status_update_deal';

    public const IMAGE_DIRECTORY = 'assets/img/uploads/deals/';

    public const STATUS = [
        'active' => 1,
        'inactive' => 0,
    ];

    protected $fillable = [
        'title',
        'slug',
        'image',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'status' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'deal_products_pvot', 'deal_id', 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS['active']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today()->toDateString());
    }
}
