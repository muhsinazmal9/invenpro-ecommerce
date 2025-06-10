<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use DefaultRouteKey, HasFactory;

    public const LIST = 'list_banner';

    public const CREATE = 'create_banner';

    public const UPDATE = 'update_banner';

    public const DELETE = 'delete_banner';

    public const STATUS_UPDATE = 'status_update_banner';

    public const IMAGE_DIRECTORY = 'assets/img/uploads/banners/';

    public const FIXED = 'fixed';

    public const SLIDER = 'slider';
    public const POPUP ='popup';
    public const BANNER='banners';

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    protected $fillable = [
        'title',
        'short_description',
        'image',
        'status',
        'slug',
        'link',
        'type',
        'countdown_start',
        'countdown_end',

    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getImageFullUrlAttribute(): string
    {
        return $this->image ? asset(self::IMAGE_DIRECTORY.$this->image) : '';
    }
}
