<?php

namespace Database\Seeders;

use App\Models\Admon\Department;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Mi compañia',
                'ruc' => 'J0031908123',
                'address' => 'Managua',
                'phone' => '86950462',
                'created_by' => 'Administrator'
            ],
        ];
        foreach ($companies as $company) {
            Company::create($company);
        }

    }
}
