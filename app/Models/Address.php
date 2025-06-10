<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE = [
        'billing' => 1,
        'shipping' => 2,
    ];

    public const LIST = 'list_address';

    public const CREATE = 'create_address';

    public const UPDATE = 'update_address';

    public const DELETE = 'delete_address';

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'email',
        'title',
        'street_address',
        'apt_or_floor',
        'zip_code',
        'city',
        'country',
        'coordinate',
        'type',
    ];

    protected $casts = [
        'zip_code' => 'integer',
        'type' => 'integer',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
