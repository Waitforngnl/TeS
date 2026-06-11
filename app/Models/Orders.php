<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'delivery_method',
        'shipping_address',
        'note',
        'sub_total',
        'shipping_fee',
        'total_price',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function item() {
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
