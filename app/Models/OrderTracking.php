<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

    protected $table = 'orders_tracking';

    protected $fillable = [
        'tracking_id',
        'order_id',
        'name',
        'description',
        'status',
        'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tracking()
    {
        return $this->belongsTo(Tracking::class);
    }
}
