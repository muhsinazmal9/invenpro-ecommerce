<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureHighlight extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'image', 'status'];

    public const LIST = 'list_feature_highlight';

    public const CREATE = 'create_feature_highlight';

    public const UPDATE = 'update_feature_highlight';

    public const IMAGE_DIRECTORY = 'assets/img/uploads/feature_highlight/';
}
