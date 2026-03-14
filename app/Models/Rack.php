<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Rack extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid','code','capacity','is_active'
    ];

    public function orderRacks()
    {
        return $this->hasMany(OrderRack::class, 'rack_uuid', 'uuid');
    }
}
