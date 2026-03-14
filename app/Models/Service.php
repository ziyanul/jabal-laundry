<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class Service extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'unit',
        'volume',
        'price'
    ];

}
