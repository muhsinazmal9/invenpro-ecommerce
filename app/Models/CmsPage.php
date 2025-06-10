<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const LIST = 'list_page';

    public const READ = 'read_page';

    public const CREATE = 'create_page';

    public const UPDATE = 'update_page';

    public const DELETE = 'delete_page';

    public const STATUS_UPDATE = 'status_update_page';

    public const STATUS = [
        'inactive' => 0,
        'active' => 1,
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
