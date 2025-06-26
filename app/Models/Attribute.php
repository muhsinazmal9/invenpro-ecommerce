<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Datatable;

class Attribute extends Model
{
    use Datatable;
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

    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_color',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_color' => 'boolean',
    ];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
