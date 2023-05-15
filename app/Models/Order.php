<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_id',
        'print_type_id',
        'qty',
        'price',
        'total',
        'discount',
        'subtotal',
        'name',
        'description',
        'order_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function printType()
    {
        return $this->belongsTo(PrintType::class);
    }

    public function orderTransaction()
    {
        return $this->hasMany(OrderTransaction::class);
    }

    public function orderTracking()
    {
        return $this->hasMany(OrderTracking::class);
    }
}
