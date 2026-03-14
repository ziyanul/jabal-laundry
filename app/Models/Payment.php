<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Payment extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'order_uuid',
        'amount',
        'method',
        'paid_at'
    ];

    protected $casts = [
    'paid_at' => 'datetime',
];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_uuid', 'uuid');
    }
}
