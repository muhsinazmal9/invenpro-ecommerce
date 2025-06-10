<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'keyword',
        'count',
    ];

    public const LIST = 'list_user_searches';

    public const DELETE = 'delete_user_searches';
}
