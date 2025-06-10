<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubsubCategory extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    public const IMAGE_DIRECTORY = 'assets/img/uploads/subsubcategories/';

    public const LIST = 'list_SubsubCategory';

    public const CREATE = 'create_SubsubCategory';

    public const UPDATE = 'update_SubsubCategory';

    public const DELETE = 'delete_SubsubCategory';

    public const STATUS_UPDATE = 'status_update_SubsubCategory';

    protected $fillable = ['title', 'status', 'subcategory_id', 'slug', 'image'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class)->where('status', Subcategory::STATUS['active']);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->published();
    }
}
