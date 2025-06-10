<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use DefaultRouteKey, HasFactory;

    public const LIST = 'list_tags';

    public const READ = 'read_tags';

    public const CREATE = 'create_tags';

    public const UPDATE = 'update_tags';

    public const DELETE = 'delete_tags';

    public const STATUS_UPDATE = 'status_update_tags';

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    protected $fillable = ['title', 'status', 'slug'];

    protected $hidden = ['deleted_at', 'pivot'];

    protected $casts = [
        'status' => 'boolean',
    ];
}
