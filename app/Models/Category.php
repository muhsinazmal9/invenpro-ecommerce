<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    protected $casts = [
        'status' => 'boolean',
    ];
    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    public const IMAGE_DIRECTORY = 'assets/img/uploads/categories/';

    public const LIST = 'list_category';

    public const CREATE = 'create_category';

    public const READ = 'read_category';

    public const UPDATE = 'update_category';

    public const DELETE = 'delete_category';

    public const PRODUCTS = 'products';

    public const SUBCATEGORIES = 'subcategories';

    public const RATINGS = 'ratings';

    public const BRANDS = 'brands';

    public const FAQS = 'faqs';

    public const STATUS_UPDATE = 'status_update_category';

    protected $fillable = ['name', 'image', 'status', 'slug', 'show_in_quick_menu', 'show_in_home_page'];

    protected $hidden = ['deleted_at'];

    public function subcategories(): HasMany
    {
        return $this->hasMany(subcategory::class);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->published();
    }
}
