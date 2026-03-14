<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Customer extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'outlet_uuid',
        'name',
        'phone',
        'address'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_uuid', 'uuid');
    }
}
