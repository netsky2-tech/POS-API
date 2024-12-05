<?php

namespace Database\Seeders;

use App\Models\Admon\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrador',
                'description' => 'Full access',
                'status' => 1,
                'created_by' => 'Administrator'
            ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }

    }
}
