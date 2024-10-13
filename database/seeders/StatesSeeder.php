<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
                ['code' => 'MX-AGU', 'alias' => 'AGS', 'name' => 'Aguascalientes', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-BCN', 'alias' => 'BC', 'name' => 'Baja California', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-BCS', 'alias' => 'BCS', 'name' => 'Baja California Sur', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-CAM', 'alias' => 'CAMP', 'name' => 'Campeche', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-CMX', 'alias' => 'CDMX', 'name' => 'Ciudad de México', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-COA', 'alias' => 'COAH', 'name' => 'Coahuila de Zaragoza', 'variant' => 'Coahuila', 'created_at' => now()]
            ,   ['code' => 'MX-COL', 'alias' => 'COL', 'name' => 'Colima', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-CHP', 'alias' => 'CHIS', 'name' => 'Chiapas', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-CHH', 'alias' => 'CHIH', 'name' => 'Chihuahua', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-DUR', 'alias' => 'DGO', 'name' => 'Durango', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-GUA', 'alias' => 'GTO', 'name' => 'Guanajuato', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-GRO', 'alias' => 'GRO', 'name' => 'Guerrero', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-HID', 'alias' => 'HGO', 'name' => 'Hidalgo', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-JAL', 'alias' => 'JAL', 'name' => 'Jalisco', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-MEX', 'alias' => 'MEX', 'name' => 'México', 'variant' => 'Estado de México', 'created_at' => now()]
            ,   ['code' => 'MX-MIC', 'alias' => 'MICH', 'name' => 'Michoacán de Ocampo', 'variant' => 'Michoacán', 'created_at' => now()]
            ,   ['code' => 'MX-MOR', 'alias' => 'MOR', 'name' => 'Morelos', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-NAY', 'alias' => 'NAY', 'name' => 'Nayarit', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-NLE', 'alias' => 'NL', 'name' => 'Nuevo León', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-OAX', 'alias' => 'OAX', 'name' => 'Oaxaca', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-PUE', 'alias' => 'PUE', 'name' => 'Puebla', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-QUE', 'alias' => 'QRO', 'name' => 'Querétaro', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-ROO', 'alias' => 'QROO', 'name' => 'Quintana Roo', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-SLP', 'alias' => 'SLP', 'name' => 'San Luis Potosí', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-SIN', 'alias' => 'SIN', 'name' => 'Sinaloa', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-SON', 'alias' => 'SON', 'name' => 'Sonora', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-TAB', 'alias' => 'TAB', 'name' => 'Tabasco', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-TAM', 'alias' => 'TAM', 'name' => 'Tamaulipas', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-TLA', 'alias' => 'TLAX', 'name' => 'Tlaxcala', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-VER', 'alias' => 'VER', 'name' => 'Veracruz de Ignacio de la Llave', 'variant' => 'Veracruz', 'created_at' => now()]
            ,   ['code' => 'MX-YUC', 'alias' => 'YUC', 'name' => 'Yucatán', 'variant' => NULL, 'created_at' => now()]
            ,   ['code' => 'MX-ZAC', 'alias' => 'ZAC', 'name' => 'Zacatecas', 'variant' => NULL, 'created_at' => now()]
        ];

        State::insert($records);
    }
}
