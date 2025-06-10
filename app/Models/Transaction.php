<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public const LIST = 'list_transactions';

    public const COD = 'COD';

    public const ONLINE = 'Online';

    public const FAILED = 'failed';

    public const SUCCESS = 'success';

    public const PENDING = 'pending';

    public const CANCEL = 'cancel';

    protected $fillable = [
        'user_id',
        'order_id',
        'transaction_id',
        'reference',
        'amount',
        'payment_method',
        'status',
        'currency',
        'bkash_transaction_id',
        'bkash_account_number',
    ];

    protected $casts = [
        'amount' => 'double',
    ];

    public const STATUS = [
        'pending' => 1,
        'failed' => 2,
        'success' => 3,
        'cancel' => 4,
    ];

    public const PAYMENT_METHOD = [
        'cod' => 1,
        'online' => 2,
        'bkash' => 3,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', self::STATUS['success']);
    }
}
