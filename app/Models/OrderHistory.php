<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class OrderHistory extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'order_code',
        'status',
        'updated_by'
    ];
}
