<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class rack extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Rack::insert([
    [
        'uuid' => Str::uuid(),
        'code' => 'RAK-A1',
        'capacity' => 100,
        'is_active' => 1
    ],
    [
        'uuid' => Str::uuid(),
        'code' => 'RAK-A2',
        'capacity' => 100,
        'is_active' => 1
    ],
]);

    }
}
