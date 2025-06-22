<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    const LIST = 'list_attribute_value';
    const CREATE = 'create_attribute_value';
    const UPDATE = 'update_attribute_value';
    const DELETE = 'delete_attribute_value';
    const STATUS_UPDATE = 'status_update_attribute_value';

    const STATUS = [
        'active' => 1,
        'inactive' => 0,
    ];

    protected $fillable = [
        'name',
        'color_code',
        'attribute_id',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
