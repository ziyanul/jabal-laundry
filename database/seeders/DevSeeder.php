<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Outlet;
use App\Models\Service;

class DevSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ OUTLET
        $outlet = Outlet::create([
            'uuid'    => Str::uuid(),
            'name'    => 'Jabal Laundry',
            'address' => 'Outlet Utama',
            'phone'   => '08123456789',
        ]);

        // 2️⃣ ROLE ADMIN
        $adminRole = Role::where('name', 'admin')->first();

        // 3️⃣ USER ADMIN
        User::create([
            'uuid'        => Str::uuid(),
            'name'        => 'Admin',
            'email'       => 'admin@laundry.test',
            'password'    => Hash::make('password'),
            'role_uuid'   => $adminRole->uuid,
            'outlet_uuid' => $outlet->uuid,
            'status'      => 'active',
        ]);

        // 4️⃣ SERVICES
        $services = [
            ['Cuci Kering', 'kg', 7000, 10],
            ['Cuci Setrika', 'kg', 9000, 10],
            ['Setrika Saja', 'kg', 5000, 10],
            ['Bed Cover', 'pcs', 25000, 15],
        ];

        foreach ($services as $s) {
            Service::create([
                'uuid'  => Str::uuid(),
                'name'  => $s[0],
                'unit'  => $s[1],
                'price' => $s[2],
                'volume'=> $s[3],
            ]);
        }
    }
}
