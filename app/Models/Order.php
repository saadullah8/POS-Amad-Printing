<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'subtotal',
        'discount',
        'total',
        'payment_method',
        'notes',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
