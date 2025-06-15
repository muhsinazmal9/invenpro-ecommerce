<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    const LIST = 'list_attribute';
    const CREATE = 'create_attribute';
    const UPDATE = 'update_attribute';
    const DELETE = 'delete_attribute';
    const STATUS_UPDATE = 'status_update_attribute';

    const STATUS = [
        'active' => 1,
        'inactive' => 0,
    ];
}
