<?php

namespace Database\Seeders;

use App\Models\Admon\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalities = [
            // Municipios de Boaco
            ['name' => 'Boaco', 'department_id' => 1],
            ['name' => 'Camoapa', 'department_id' => 1],
            ['name' => 'San José de los Remates', 'department_id' => 1],
            ['name' => 'San Lorenzo', 'department_id' => 1],
            ['name' => 'Santa Lucía', 'department_id' => 1],
            ['name' => 'Teustepe', 'department_id' => 1],

            // Municipios de Carazo
            ['name' => 'Diriamba', 'department_id' => 2],
            ['name' => 'Dolores', 'department_id' => 2],
            ['name' => 'El Rosario', 'department_id' => 2],
            ['name' => 'Jinotepe', 'department_id' => 2],
            ['name' => 'La Conquista', 'department_id' => 2],
            ['name' => 'La Paz de Carazo', 'department_id' => 2],
            ['name' => 'San Marcos', 'department_id' => 2],
            ['name' => 'Santa Teresa', 'department_id' => 2],

            // Municipios de Chinandega
            ['name' => 'Chichigalpa', 'department_id' => 3],
            ['name' => 'Chinandega', 'department_id' => 3],
            ['name' => 'Corinto', 'department_id' => 3],
            ['name' => 'El Realejo', 'department_id' => 3],
            ['name' => 'El Viejo', 'department_id' => 3],
            ['name' => 'Posoltega', 'department_id' => 3],
            ['name' => 'Puerto Morazán', 'department_id' => 3],
            ['name' => 'Somotillo', 'department_id' => 3],
            ['name' => 'Villanueva', 'department_id' => 3],

            // Municipios de Chontales
            ['name' => 'Acoyapa', 'department_id' => 4],
            ['name' => 'Comalapa', 'department_id' => 4],
            ['name' => 'Cuapa', 'department_id' => 4],
            ['name' => 'El Coral', 'department_id' => 4],
            ['name' => 'Juigalpa', 'department_id' => 4],
            ['name' => 'La Libertad', 'department_id' => 4],
            ['name' => 'San Pedro de Lóvago', 'department_id' => 4],
            ['name' => 'Santo Domingo', 'department_id' => 4],
            ['name' => 'Santo Tomás', 'department_id' => 4],
            ['name' => 'Villa Sandino', 'department_id' => 4],

            // Municipios de Estelí
            ['name' => 'Condega', 'department_id' => 5],
            ['name' => 'Estelí', 'department_id' => 5],
            ['name' => 'La Trinidad', 'department_id' => 5],
            ['name' => 'Pueblo Nuevo', 'department_id' => 5],
            ['name' => 'San Juan de Limay', 'department_id' => 5],
            ['name' => 'San Nicolás', 'department_id' => 5],

            // Municipios de Granada
            ['name' => 'Diriá', 'department_id' => 6],
            ['name' => 'Diriomo', 'department_id' => 6],
            ['name' => 'Granada', 'department_id' => 6],
            ['name' => 'Nandaime', 'department_id' => 6],

            // Municipios de Jinotega
            ['name' => 'El Cuá', 'department_id' => 7],
            ['name' => 'Jinotega', 'department_id' => 7],
            ['name' => 'La Concordia', 'department_id' => 7],
            ['name' => 'San José de Bocay', 'department_id' => 7],
            ['name' => 'San Rafael del Norte', 'department_id' => 7],
            ['name' => 'San Sebastián de Yalí', 'department_id' => 7],
            ['name' => 'Santa María de Pantasma', 'department_id' => 7],
            ['name' => 'Wiwilí', 'department_id' => 7],

            // Municipios de León
            ['name' => 'Achuapa', 'department_id' => 8],
            ['name' => 'El Jicaral', 'department_id' => 8],
            ['name' => 'El Sauce', 'department_id' => 8],
            ['name' => 'La Paz Centro', 'department_id' => 8],
            ['name' => 'León', 'department_id' => 8],
            ['name' => 'Nagarote', 'department_id' => 8],
            ['name' => 'Quezalguaque', 'department_id' => 8],
            ['name' => 'Santa Rosa del Peñón', 'department_id' => 8],
            ['name' => 'Telica', 'department_id' => 8],

            // Municipios de Madriz
            ['name' => 'Las Sabanas', 'department_id' => 9],
            ['name' => 'Palacagüina', 'department_id' => 9],
            ['name' => 'San José de Cusmapa', 'department_id' => 9],
            ['name' => 'San Juan del Río Coco', 'department_id' => 9],
            ['name' => 'Somoto', 'department_id' => 9],
            ['name' => 'Telpaneca', 'department_id' => 9],
            ['name' => 'Totogalpa', 'department_id' => 9],
            ['name' => 'Yalagüina', 'department_id' => 9],

            // Municipios de Managua
            ['name' => 'Ciudad Sandino', 'department_id' => 10],
            ['name' => 'El Crucero', 'department_id' => 10],
            ['name' => 'Managua', 'department_id' => 10],
            ['name' => 'Mateare', 'department_id' => 10],
            ['name' => 'San Francisco Libre', 'department_id' => 10],
            ['name' => 'San Rafael del Sur', 'department_id' => 10],
            ['name' => 'Ticuantepe', 'department_id' => 10],
            ['name' => 'Tipitapa', 'department_id' => 10],
            ['name' => 'Villa El Carmen', 'department_id' => 10],

            // Municipios de Masaya
            ['name' => 'Catarina', 'department_id' => 11],
            ['name' => 'La Concepción', 'department_id' => 11],
            ['name' => 'Masatepe', 'department_id' => 11],
            ['name' => 'Masaya', 'department_id' => 11],
            ['name' => 'Nandasmo', 'department_id' => 11],
            ['name' => 'Nindirí', 'department_id' => 11],
            ['name' => 'San Juan de Oriente', 'department_id' => 11],
            ['name' => 'Tisma', 'department_id' => 11],

            // Municipios de Matagalpa
            ['name' => 'Ciudad Darío', 'department_id' => 12],
            ['name' => 'El Tuma - La Dalia', 'department_id' => 12],
            ['name' => 'Esquipulas', 'department_id' => 12],
            ['name' => 'Matagalpa', 'department_id' => 12],
            ['name' => 'Matiguás', 'department_id' => 12],
            ['name' => 'Muy Muy', 'department_id' => 12],
            ['name' => 'Rancho Grande', 'department_id' => 12],
            ['name' => 'Río Blanco', 'department_id' => 12],
            ['name' => 'San Dionisio', 'department_id' => 12],
            ['name' => 'San Isidro', 'department_id' => 12],
            ['name' => 'San Ramón', 'department_id' => 12],
            ['name' => 'Sébaco', 'department_id' => 12],
            ['name' => 'Terrabona', 'department_id' => 12],

            // Municipios de Nueva Segovia
            ['name' => 'Ciudad Antigua', 'department_id' => 13],
            ['name' => 'Dipilto', 'department_id' => 13],
            ['name' => 'El Jícaro', 'department_id' => 13],
            ['name' => 'Jalapa', 'department_id' => 13],
            ['name' => 'Macuelizo', 'department_id' => 13],
            ['name' => 'Mozonte', 'department_id' => 13],
            ['name' => 'Murra', 'department_id' => 13],
            ['name' => 'Ocotal', 'department_id' => 13],
            ['name' => 'Quilalí', 'department_id' => 13],
            ['name' => 'San Fernando', 'department_id' => 13],
            ['name' => 'Santa María', 'department_id' => 13],
            ['name' => 'Wiwilí de Nueva Segovia', 'department_id' => 13],

            // Municipios de Río San Juan
            ['name' => 'El Almendro', 'department_id' => 14],
            ['name' => 'El Castillo', 'department_id' => 14],
            ['name' => 'Morrito', 'department_id' => 14],
            ['name' => 'San Carlos', 'department_id' => 14],
            ['name' => 'San Juan de Nicaragua', 'department_id' => 14],
            ['name' => 'San Miguelito', 'department_id' => 14],

            // Municipios de Rivas
            ['name' => 'Altagracia', 'department_id' => 15],
            ['name' => 'Belén', 'department_id' => 15],
            ['name' => 'Buenos Aires', 'department_id' => 15],
            ['name' => 'Cárdenas', 'department_id' => 15],
            ['name' => 'Moyogalpa', 'department_id' => 15],
            ['name' => 'Potosí', 'department_id' => 15],
            ['name' => 'Rivas', 'department_id' => 15],
            ['name' => 'San Jorge', 'department_id' => 15],
            ['name' => 'San Juan del Sur', 'department_id' => 15],
            ['name' => 'Tola', 'department_id' => 15],

            // Municipios de las Regiones Autónomas (Caribe Norte y Sur)
            // Región Autónoma del Caribe Norte
            ['name' => 'Bonanza', 'department_id' => 16],
            ['name' => 'Mulukukú', 'department_id' => 16],
            ['name' => 'Prinzapolka', 'department_id' => 16],
            ['name' => 'Puerto Cabezas', 'department_id' => 16],
            ['name' => 'Rosita', 'department_id' => 16],
            ['name' => 'Siuna', 'department_id' => 16],
            ['name' => 'Waslala', 'department_id' => 16],
            ['name' => 'Waspam', 'department_id' => 16],

            // Región Autónoma del Caribe Sur
            ['name' => 'Bluefields', 'department_id' => 17],
            ['name' => 'Corn Island', 'department_id' => 17],
            ['name' => 'Desembocadura de Río Grande', 'department_id' => 17],
            ['name' => 'El Ayote', 'department_id' => 17],
            ['name' => 'El Rama', 'department_id' => 17],
            ['name' => 'El Tortuguero', 'department_id' => 17],
            ['name' => 'Kukra Hill', 'department_id' => 17],
            ['name' => 'Laguna de Perlas', 'department_id' => 17],
            ['name' => 'La Cruz de Río Grande', 'department_id' => 17],

        ];

        foreach ($municipalities as $municipality) {
            Municipality::create($municipality);
        }
    }
}
