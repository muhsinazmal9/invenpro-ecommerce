<?php

namespace App\Models;

use App\Models\Wishlist;
use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const THUMBNAIL_DIRECTORY = 'assets/img/uploads/products/';

    public const SIZE_CHART_DIRECTORY = 'assets/img/uploads/products/size_chart/';

    public const GALLERY_IMG_PATH = 'assets/img/uploads/products/gallery/';

    public const PRODUCT_REVIEWS_DIRECTORY  = 'assets/img/uploads/products/product_reviews/';

    public const LIST = 'list_products';

    public const CREATE = 'create_product';

    public const SHOW = 'show_product';

    public const UPDATE = 'update_product';

    public const DELETE = 'delete_product';

    public const STATUS_UPDATE = 'status_update_product';

    public const FEATURE_STATUS_UPDATE = 'feature_status_update_product';

    public const NEW_ARRIVAL_STATUS_UPDATE = 'new_arrival_status_update_product';

    public const LOW_STOCK = 'lowstock';

    public const TOP_PRODUCT = 'topproduct';

    public const ATTRIBUTE_COLOR = 'color';

    public const DISCOUNT_TYPE = [
        'fixed' => 'FIXED',
        'percentage' => 'PERCENTAGE',
    ];

    public const STATUS = [
        'published' => 'PUBLISHED',
        'draft' => 'DRAFT',
    ];

    public const FEATURED = [
        'active' => true,
        'inactive' => false,
    ];

    public const NEW_ARRIVAL = [
        'active' => true,
        'inactive' => false,
    ];

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'size_chart',
        'short_description',
        'long_description',
        'sku',
        'price',
        'discount',
        'discount_type',
        'stock',
        'seo_title',
        'keywords',
        'seo_description',
        'category_id',
        'subcategory_id',
        'subsub_category_id',
        'brand_id',
        'featured',
        'new_arrival',
        'status',
        'tax_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'new_arrival' => 'boolean',
        'status' => 'string',
        'price' => 'double',
        'discount' => 'double',
        'stock' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->where('status', Category::STATUS['active'])->withDefault();
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class)->where('status', Subcategory::STATUS['active'])->withDefault();
    }

    public function subsubCategory(): BelongsTo
    {
        return $this->belongsTo(SubsubCategory::class)->where('status', SubsubCategory::STATUS['active'])->withDefault();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class)->where('status', Brand::STATUS['active'])->withDefault();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags_pvot', 'product_id', 'tag_id')->where('status', Tag::STATUS['active']);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function getThumbnailFullUrlAttribute(): string
    {
        return $this->thumbnail ? asset($this->thumbnail) : '';
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function getRattingAttribute()
    {
        return (float) number_format($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function customAttributes(): HasMany
    {
        return $this->hasMany(ProductCustomAttribute::class, 'product_id');
    }

    public function scopeLow($query)
    {
        return $query->where('stock', '<=', getSetting('low_stock'));
    }

    public function scopePublished($query)
    {
        // checking all dependency if activated or not.
        return $query->whereHas('category', function ($query) {
            $query->where('status', Category::STATUS['active']);
        })->whereHas('subcategory', function ($query) {
            $query->where('status', Subcategory::STATUS['active']);
        })->whereHas('subsubCategory', function ($query) {
            $query->where('status', SubsubCategory::STATUS['active']);
        })->whereHas('brand', function ($query) {
            $query->where('status', Brand::STATUS['active']);
        })->where('status', self::STATUS['published']);
    }
    public function scopeStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class, 'deal_products_pvot', 'product_id', 'deal_id')->where('status', Deal::STATUS['active']);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(TaxSettings::class)->active();
    }
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }
}
