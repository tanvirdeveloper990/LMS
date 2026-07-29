<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

protected static function boot()
{
    parent::boot();

    static::created(function ($order) {
        if (empty($order->order_id)) {
            $order->order_id = 100 + $order->id;
            $order->saveQuietly(); // saveQuietly() যাতে event আবার fire না হয়
        }
    });
}

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'order_items', 'order_id', 'vendor_id');
    }


     public function reviews()
    {
        return $this->hasMany(CustomerReview::class, 'product_id')
                    ->where('status', 1)
                    ->latest();
    }
}
