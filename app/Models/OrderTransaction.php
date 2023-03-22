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
        'amount',
        'date',
    ];
}
