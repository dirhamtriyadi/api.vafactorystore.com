<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $table = 'orders_transactions';

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'user_id',
        'amount',
        'description',
        'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    function user() {
        return $this->belongsTo(User::class);
    }
}
