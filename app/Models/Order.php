<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Order extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'customer_uuid',
        'outlet_uuid',
        'invoice_code',
        'order_code',
        'order_date',
        'total_price',
        'payment_status',
        'paid_amount',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // UUID SUDAH ditangani trait
            // di sini hanya logic lain
            if (empty($model->invoice_code)) {
                $model->invoice_code = 'INV-' . now()->format('YmdHis');
            }

            if (empty($model->status)) {
                $model->status = 'process';
            }
        });
    }

    protected $casts = [
        'order_date' => 'datetime', // ⬅️ ini penting
    ];
    
    public function getRouteKeyName()
    {
        return 'order_code';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_uuid', 'uuid');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_uuid', 'uuid');
    }

    public function histories()
    {
        return $this->hasMany(OrderHistory::class, 'order_code', 'order_code')
                    ->orderBy('created_at');
    }

    public function payments()
{
    return $this->hasMany(Payment::class, 'order_uuid', 'uuid');
}

public function getRemainingPaymentAttribute()
{
    return $this->total_price - $this->paid_amount;
}

public function orderRacks()
{
    return $this->hasMany(OrderRack::class, 'order_uuid', 'uuid');
}

}
