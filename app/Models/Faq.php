<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use DefaultRouteKey, HasFactory, SoftDeletes;

    public const LIST = 'list_faq';

    public const CREATE = 'create_faq';

    public const UPDATE = 'update_faq';

    public const DELETE = 'delete_faq';

    public const STATUS_UPDATE = 'status_update_faq';

    public const STATUS = [
        'active' => true,
        'inactive' => false,
    ];

    protected $fillable = [
        'question',
        'answer',
        'category_id',
        'status',
        'slug',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
