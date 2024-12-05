<?php

namespace Database\Seeders;

use App\Models\Admon\Department;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'company_id' => 1,
                'branch_id' => 1,
                'role_id' => 1,
                'name' => 'Administrator',
                'full_name' => 'Administrador sistema',
                'email' => 'administrator@example.com',
                'password' => 'administrator',
                'created_by' => 'Administrator'
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }

    }
}
