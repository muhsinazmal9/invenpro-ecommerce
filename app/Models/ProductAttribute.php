<?php

namespace App\Models;

use App\Models\Scopes\ProductAttributeItemsRelationalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAttribute extends Model
{
    use HasFactory;

    // add global scope
    protected static function booted()
    {
        static::addGlobalScope(new ProductAttributeItemsRelationalScope());
    }

    protected $fillable = [
        'product_id',
        'name',
        'type',
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
    ];

    public const ATTRIBUTE_TYPE = [
        'size' => 'SIZE',
        'color' => 'COLOR',
        'unit' => 'UNIT',
        'custom' => 'CUSTOM',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductAttributeItem::class, 'attribute_id');
    }
}
