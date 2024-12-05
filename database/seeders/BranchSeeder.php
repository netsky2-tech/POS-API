<?php

namespace Database\Seeders;

use App\Models\Admon\Department;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'company_id' => 1,
                'name' => 'Central',
                'address' => 'Managua',
                'phone' => '86950462',
                'created_by' => 'Administrator'
            ],
        ];
        foreach ($branches as $branch) {
            Branch::create($branch);
        }

    }
}
