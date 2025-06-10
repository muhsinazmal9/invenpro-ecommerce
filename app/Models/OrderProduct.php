<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_json',
        'meta',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'double',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isReviewed(): bool
    {
        return ProductReview::where('product_id', $this->product_id)
            ->where('order_id', $this->order_id)
            ->where('user_id', auth('sanctum')->user()?->id)
            ->exists();
    }
}
