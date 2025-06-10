<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Wishlist;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    protected const USERNAME = 'username';

    // public const DEFAULT_IMAGE = asset('assets/img/uploads/user/avatar/default.png');
    public const LIST = 'list_user';

    public const READ = 'read_user';

    public const CREATE = 'create_user';

    public const UPDATE = 'update_user';

    public const DELETE = 'delete_user';

    public const STATUS_UPDATE = 'status_update_user';

    public const ASSIGN_ROLE = 'assign_role_user';

    public const BEARER = 'Bearer';

    public const CUSTOMER = 'Customer';

    public const USER = 'User';

    public const GOOGLE = 'google';

    public const IMAGE_DIRECTORY = 'assets/img/uploads/user/avatar/';

    public const STATUS = [
        'active' => 'ACTIVE',
        'blocked' => 'BLOCKED',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'status',
        'username',
        'email_verified_at',
        'otp',
        'otp_expired_at',
        'image',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'otp',
        'otp_expired_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getRouteKeyName(): string
    {
        return self::USERNAME;
    }

    public function getNameAttribute(): string
    {
        return $this->fname.' '.$this->lname;
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function getRoleNameAttribute()
    {
        return $this->getRoleNames()[0];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'user_id');
    }

    // public function getImageAttribute($value): string
    // {
    //     return $value ? asset($value) : asset(getSetting('default_avatar'));
    // }
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }
}
