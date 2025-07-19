<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Brand extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    public const IMAGE_DIRECTORY = 'assets/img/uploads/brands/';

    public const LIST = 'list_brand';

    public const CREATE = 'create_brand';

    public const UPDATE = 'update_brand';

    public const DELETE = 'delete_brand';

    public const STATUS_UPDATE = 'status_update_brand';

    protected $fillable = ['title', 'slug', 'status', 'image'];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc');
        });
    }

    public function getImageURLAttribute()
    {
        return $this->image ? asset($this->image) : getPlaceholderImage('160','100');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS['active']);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->published();
    }
}
