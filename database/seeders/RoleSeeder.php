<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'label' => 'Administrator'],
            ['name' => 'kasir', 'label' => 'Kasir'],
            ['name' => 'karyawan', 'label' => 'Karyawan'],
            ['name' => 'owner', 'label' => 'Owner'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                [
                    'uuid'  => Str::uuid(),
                    'label' => $role['label']
                ]
            );
        }
    }
}
