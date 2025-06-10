<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory,SoftDeletes;

    public const LIST = 'list_newsletter';

    public const CREATE = 'create_newsletter';

    public const DELETE = 'delete_subscriber';

    protected $fillable = ['email', 'is_subscribed', 'meta', 'token'];

    protected $casts = ['is_subscribed' => 'boolean'];

    protected $hidden = [
        'deleted_at',
    ];

    public function scopeSubscribed(Builder $query): Builder
    {
        return $query->where('is_subscribed', true);
    }

    public function getRouteKeyName()
    {
        return 'token';
    }
}
