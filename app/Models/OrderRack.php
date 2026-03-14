<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class OrderRack extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid','order_uuid','rack_uuid','used_capacity','is_done'
    ];

    public function rack()
    {
        return $this->belongsTo(Rack::class, 'rack_uuid', 'uuid');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_uuid', 'uuid');
    }
}
