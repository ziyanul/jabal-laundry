<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class OrderItem extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'order_uuid',
        'service_uuid',
        'qty',
        'price',
        'subtotal'
    ];


    public function service()
    {
        return $this->belongsTo(Service::class, 'service_uuid', 'uuid');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_uuid', 'order_uuid');
    }
}
