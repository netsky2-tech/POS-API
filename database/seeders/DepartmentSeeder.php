<?php

namespace Database\Seeders;

use App\Models\Admon\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Boaco'],
            ['name' => 'Carazo'],
            ['name' => 'Chinandega'],
            ['name' => 'Chontales'],
            ['name' => 'Estelí'],
            ['name' => 'Granada'],
            ['name' => 'Jinotega'],
            ['name' => 'León'],
            ['name' => 'Madriz'],
            ['name' => 'Managua'],
            ['name' => 'Masaya'],
            ['name' => 'Matagalpa'],
            ['name' => 'Nueva Segovia'],
            ['name' => 'Rivas'],
            ['name' => 'Río San Juan'],
            ['name' => 'RAAN'], // Región Autónoma Atlántico Norte
            ['name' => 'RAAS'], // Región Autónoma Atlántico Sur
        ];
        foreach ($departments as $department) {
            Department::create($department);
        }

    }
}
