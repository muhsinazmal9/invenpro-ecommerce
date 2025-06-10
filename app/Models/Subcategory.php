<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    public const LIST = 'list_subcategory';

    public const CREATE = 'create_subcategory';

    public const UPDATE = 'update_subcategory';

    public const DELETE = 'delete_subcategory';

    public const SUBSUBCATEGORIES = 'subsubcategories';

    public const STATUS_UPDATE = 'status_update_subcategory';

    public const IMAGE_DIRECTORY = 'assets/img/uploads/subcategories/';

    protected $fillable = ['title', 'image', 'status', 'category_id', 'slug'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->published();
    }

    public function subsubCategories(): HasMany
    {
        return $this->hasMany(SubsubCategory::class)->where('status', SubsubCategory::STATUS['active']);
    }
}
