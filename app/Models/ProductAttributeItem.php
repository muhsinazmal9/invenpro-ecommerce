<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'name',
        'price_adjustment',
        'code',
    ];

    protected $casts = [
        'price_adjustment' => 'double',
        'code' => 'string',
        'name',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}
