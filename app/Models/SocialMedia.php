<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    public const ACTIVE = 1;

    public const INACTIVE = 0;

    public const SOCIAL_MEDIA_SETTINGS = 'social_media_settings';

    protected $fillable = [
        'platform_id',
        'username',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getPlatformAttribute()
    {
        return collect(json_decode(file_get_contents(base_path('json/social_media.json'))))?->where('id', $this->platform_id)?->first();
    }

    public function getFullUrl(): string
    {
        return $this->platform?->url.'/'.$this->username;

    }
}
