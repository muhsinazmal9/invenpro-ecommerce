<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxSettings extends Model
{
    use DefaultRouteKey, HasFactory;

    public const ACTIVE = 1;

    public const INACTIVE = 0;

    public const TAX_SETTINGS = 'tax_settings';

    protected $fillable = [
        'code',
        'rate',
        'status',
        'slug',
    ];

    protected $casts = [
        'status' => 'boolean',
        'rate' => 'float',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'tax_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }
}
