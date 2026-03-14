<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Outlet extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'address',
        'phone',
        'is_active'
    ];
}
