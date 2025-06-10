<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public const LIST = 'list_order';

    public const CANCEL_REQUEST_APPROVE = 'cancel_request_approve_order';

    public const DETAILS_VIEW = 'view_order_details';

    public const STATUS_UPDATE = 'status_update_order';

    public const GIFT_STATUS_UPDATE = 'gift_status_update_order';

    public const PAYMENT_METHOD = [
        'cod' => 'cod',
        'online' => 'online',
        'bkash' => 'bkash',
    ];

    public const DELIVERY_TYPE = [
        'pickup' => 'pickup',
        'delivery' => 'delivery',
    ];

    public const PAYMENT_STATUS = [
        'pending' => 'pending',
        'paid' => 'paid',
        'failed' => 'failed',
    ];

    public const GIFT_STATUS = [
        'yes' => 1,
        'no' => 0,

    ];

    public const ORDER_STATUS = [
        'placed' => 'placed',
        'approved' => 'approved',
        'shipped' => 'shipped',
        'delivered' => 'delivered',
        'cancelled' => 'cancelled',
    ];

    public const CANCEL_REQUEST = [
        'no_request' => 0,
        'requested' => 1,
        'approved' => 2,
        'rejected' => 3,
    ];

    protected $fillable = [
        'invoice_id',
        'user_id',
        'shipping_address',
        'billing_address',
        'delivery_instruction',
        'delivery_time',
        'delivery_date',
        'delivery_type',
        'payment_status',
        'payment_method',
        'order_status',
        'is_cancel_request',
        'is_gift',
        'is_gift_wrapping',
        'gift',
        'promo',
        'discount',
        'gift_wrapper_charge',
        'tax',
        'service_amount',
        'subtotal',
        'shipping_charge',
        'grand_total',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'is_gift' => 'boolean',
        'discount' => 'double',
        'tax' => 'double',
        'service_amount' => 'double',
        'subtotal' => 'double',
        'shipping_charge' => 'double',
        'grand_total' => 'double',
        'delivery_date' => 'datetime',
        'is_cancel_request' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'order_id');
    }

    public function orderLogs(): HasMany
    {
        return $this->hasMany(OrderLog::class);
    }
}
