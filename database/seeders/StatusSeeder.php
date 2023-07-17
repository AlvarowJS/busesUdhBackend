<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            'nombre' => "En recorrido",
            'descripcion' => "El bus se encuentra en recorrido",
            'color' => "green"
        ]);

        DB::table('status')->insert([
            'nombre' => "Esperando estudiantes",
            'descripcion' => "El bus se encuentra esperando pasajeros, apresurate",
            'color' => "yellow"
        ]);

        DB::table('status')->insert([
            'nombre' => "Bus con avería",
            'descripcion' => "El bus se encuentra llenando gasolina, puede tardar un poco...",
            'color' => "red",
        ]);
        DB::table('status')->insert([
            'nombre' => "Fuera de servicio",
            'descripcion' => "El bus hoy no se encuentra trabajando :(",
            'color' => "black"
        ]);
    }
}
